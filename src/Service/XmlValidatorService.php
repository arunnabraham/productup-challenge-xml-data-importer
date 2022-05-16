<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Eclipxe\XmlSchemaValidator\SchemaValidator;
use Exception;
use Buzz\Browser;
use Buzz\Client\FileGetContents;
use Nyholm\Psr7\Factory\Psr17Factory;


class XmlValidatorService
{
    private string $inputFile;
    private string $inputType;
    public function validateXml(string $inputFile, string $inputType): bool
    {
        try {
            $this->inputFile = $inputFile;
            $this->inputType = $inputType;
            $inputTypeValidate = $this->validateInputType();
            if ($inputTypeValidate['status']) {
                throw new Exception($inputTypeValidate['info']);
            }
            $xmlData = file_get_contents($inputFile);
            $schemaValidator = SchemaValidator::createFromString($xmlData);
            return $schemaValidator->validate();
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    private function validateInputType(): array
    {
        return match ($this->inputType) {

            'local' => (fn (): array => is_string(realpath($this->inputFile)) ? [
                'status' => true
            ] : [
                'status' => false,
                'Info' => 'Invalid File Input'
            ])(),

            'remote' => (fn (): array => ($this->isRemoteFileExists()) ? [
                'status' => true
            ] : [
                'status' => false,
                'Info' => 'Invalid Remote file Input'
            ])(),

            default => [
                'status' => false,
                'Info' => 'Unknown Input Type'
            ]
        };
    }

    private function isRemoteFileExists(): bool
    {
        try {
            $client = new FileGetContents(new Psr17Factory());
            $browser = new Browser($client, new Psr17Factory());
            $response = $browser->get($this->inputFile);
            return $response->getStatusCode() === '200' ? true : false;
        } catch (\Exception $e) {
        }
        return false;
    }
}
