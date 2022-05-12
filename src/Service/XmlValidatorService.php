<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Exception;
use Eclipxe\XmlSchemaValidator\SchemaValidator;

class XmlValidatorService
{
    public function validateXml(string $xmlData): bool
    {
        try {
           $schemaValidator = SchemaValidator::createFromString($xmlData);
            return $schemaValidator->validate();
        } catch (Exception $e) {
            return false;
        }
    }
}
