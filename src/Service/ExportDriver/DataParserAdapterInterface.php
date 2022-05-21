<?php
namespace Arunnabraham\XmlDataImporter\Service\ExportDriver;

interface DataParserAdapterInterface {

    public function processData($inputStream): bool;
    public function returnExportOutput($exportLocation, $inputStream): string;

}
