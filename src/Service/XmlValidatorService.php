<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter;

use Exception;
use Eclipxe\XmlSchemaValidator\SchemaValidator;

class XmlValidatorService
{
    public function validateXml(string $xmlData): bool
    {
        try {
           $schemaValidator = SchemaValidator::createFromString($xmlData);
            $serialize = (new SchemaValidator($xmlData))->validate();
        } catch (Exception $e) {
        }
    }
}
