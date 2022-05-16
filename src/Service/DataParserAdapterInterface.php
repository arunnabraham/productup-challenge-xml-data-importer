<?php
namespace Arunnabraham\XmlDataImporter\Service;

use Arunnabraham\XmlDataImporter\Service\ExportIO\DisplayFormatIO;

interface DataParserAdapterInterface {

    public function processData($inputStream): bool;
    public function returnExportOutput($exportLocation, $inputStream): string;

}
