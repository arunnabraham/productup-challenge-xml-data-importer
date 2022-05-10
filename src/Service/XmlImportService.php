<?php
declare(strict_types=1);
namespace Arunnabraham\XmlDataImporter;

use Arunnabraham\XmlDataImporter\DataParserAdapterInterface as XmlDataImporterDataParserAdapterInterface;
use Arunnabraham\XmlDataImporter\XmlImportService as XmlImport;
use DataParserAdapterInterface;

class XmlImportService
{

    public function xmlToFormatOut(): void
    {
        $this->processImport(XmlDataImporterDataParserAdapterInterface $adapter);
    }

    public function processImport(DataParserAdapterInterface $outputParser): void
    {

    }

    public function importFromLocation($inputLocation, int $parserOption): string
    {
        return '';
    }
}
