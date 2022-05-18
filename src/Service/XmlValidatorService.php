<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Eclipxe\XmlSchemaValidator\SchemaValidator;
use Exception;
use Buzz\Browser;
use Buzz\Client\Curl;
use Monolog\Logger;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

class XmlValidatorService
{
    private ResponseInterface $remoteFileResponse;
    public function validateXml($inputFile): bool
    {
        try {
            //$xmlData = file_get_contents($inputFile);
            //echo $xmlData; exit;
            $XMLReader = new \XMLReader();

            // Open the XML file
            $XMLReader->open($inputFile);

            // Enable the Parser Property
            $XMLReader->setParserProperty(
                \XMLReader::VALIDATE,
                true
            );

            // Iterate through the XML nodes
            while ($XMLReader->read()) {
                if ($XMLReader->nodeType == \XMLREADER::ELEMENT) {

                    // Check if XML is valid or not
                    $isValid = $XMLReader->isValid();
                    if ($isValid) {
                        echo "YES ! this node is validated<br>";
                    }
                }
            }
            exit;
            return true;
            //$schemaValidator = SchemaValidator::createFromString($xmlData);
            //return $schemaValidator->validate();
        } catch (Exception $e) {
            appLogger('error', 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString());
            return false;
        }
        return false;
    }
}
