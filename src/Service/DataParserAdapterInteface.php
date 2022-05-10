<?php
namespace Arunnabraham\XmlDataImporter;
interface DataParserAdapterInterface {

    public function processData(string $inputData);
    public function exportToLocation(string $outputLocation=".");

}