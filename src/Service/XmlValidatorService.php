<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Eclipxe\XmlSchemaValidator\SchemaValidator;
use Exception;
use Buzz\Browser;
use Buzz\Client\Curl;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use XMLReader;

class XmlValidatorService
{
    private string $inputFile;
    private string $inputType;
    private ResponseInterface $remoteFileResponse;
    public function validateXml(string $inputFile, string $inputType): bool
    {
        try {
            $this->inputFile = $inputFile;
            $this->inputType = $inputType;
            if ($inputType === 'remote') {
                $response = $this->getRemoteFile();
                $this->remoteFileResponse = $response;
                if ($this->remoteFileResponse instanceof ResponseInterface) {
                    $xmlData = $this->remoteFileResponse->getBody()->getContents();
                } else {
                    $xmlData = '';
                }
            } else {
                $xmlData = file_get_contents($this->inputFile);
            }
            $inputTypeValidate = $this->validateInputType();
            if (!$inputTypeValidate['status']) {
                throw new \Exception($inputTypeValidate['info']);
            }
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
                'info' => 'Invalid File Input'
            ])(),

            'remote' => (fn (): array => ($this->isRemoteFileExists()) ? [
                'status' => true
            ] : [
                'status' => false,
                'info' => 'Invalid Remote file Input'
            ])(),

            default => [
                'status' => false,
                'info' => 'Unknown Input Type'
            ]
        };
    }

    private function getRemoteFile(): ResponseInterface|bool
    {
        try {
            $client = new Curl(new Psr17Factory());
            $browser = new Browser($client, new Psr17Factory());
            $response = $browser->get($this->inputFile);
            return $response;
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }

    private function isRemoteFileExists()
    {
        if ($this->remoteFileResponse instanceof ResponseInterface) {
            return $this->remoteFileResponse->getStatusCode() === 200 ? true : false;
        }
        return false;
    }
}
