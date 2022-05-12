<?php
namespace Arunnabraham\XmlDataImporter\Service;
interface DataParserAdapterInterface {

    public function processData(): string;
    public function returnOutput(string $inputData): string;

}
