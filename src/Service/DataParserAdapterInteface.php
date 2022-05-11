<?php
namespace Arunnabraham\XmlDataImporter;
interface DataParserAdapterInterface {

    public function processData(): string;
    public function returnOutput(string $inputData):

}