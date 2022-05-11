<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter;

use Arunnabraham\XmlDataImporter\DataParserAdapterInterface as XmlDataImporterDataParserAdapterInterface;
use Arunnabraham\XmlDataImporter\XmlImportService as XmlImport;
use DataParserAdapterInterface;
use Exception;

class XmlImportService
{

    public function xmlToFormatOut(): void
    {
    }

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

    public function importFromLocation($inputLocation, int $parserOption): string
    {
        return '';
    }
}
