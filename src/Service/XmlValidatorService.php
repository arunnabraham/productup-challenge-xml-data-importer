<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Eclipxe\XmlSchemaValidator\SchemaValidator;
use Exception;
use Psr\Http\Message\ResponseInterface;

class XmlValidatorService
{
    public function validateXml($inputFile): bool
    {
        try {
            $xmlData = file_get_contents($inputFile);

            $schemaValidator = SchemaValidator::createFromString($xmlData);
            if ($schemaValidator->validate() === false) {
                throw new Exception('Invalid XML Schema');
            } else {
                return true;
            }
        } catch (Exception $e) {
            appLogger('error', 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString());
            return false;
        }
        return false;
    }
}
