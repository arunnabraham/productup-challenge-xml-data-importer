<?php
namespace Arunnabraham\XmlDataImporter\Service;

interface DataParserAdapterInterface {

    public function processData($inputStream): bool;
    public function returnExportOutput($exportLocation, $inputStream): string;

}
