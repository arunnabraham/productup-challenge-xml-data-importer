<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Arunnabraham\XmlDataImporter\Service\DataParserAdapterInterface as XmlDataImporterDataParserAdapterInterface;
use Exception;

class XmlImportService
{

    public function processImport(XmlDataImporterDataParserAdapterInterface $outputParser, string $input): void
    {
        try {
            if ((new XmlValidatorService)->validateXml($input)) {

                $outputParser->returnOutput($input);
            } else {
                throw new Exception('Invalid XML input');
            }
        } catch (\Exception $e) {
        }
    }

    private function writeToStream($node)
    {
        $streamMemoryPointer =  fopen('php://memory', 'rw');
        $this->putNodeResultToStream($node, $streamMemoryPointer);
        fclose($streamMemoryPointer);
    }

    private function putNodeResultToStream()

}
