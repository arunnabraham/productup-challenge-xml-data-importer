<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\XMLImportExport;

use Eclipxe\XmlSchemaValidator\SchemaValidator;
use Exception;
use Throwable;

class XmlValidatorService
{
    public function validateXml(string $inputFile): bool
    {
        try {
            $xmlData = file_get_contents($inputFile);

            $schemaValidator = SchemaValidator::createFromString($xmlData);
            if ($schemaValidator->validate() === false) {
                throw new Exception('Invalid XML Schema');
            } else {
                return true;
            }
        } catch (Throwable $e) {
            appLogger('error', 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString());
            return false;
        }
        return false;
    }
}
