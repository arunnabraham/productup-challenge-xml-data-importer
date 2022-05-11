<?php
declare(strict_types=1);
namespace Arunnabraham\XmlDataImporter\Service\Formats;

use Arunnabraham\XmlDataImporter\DataParserAdapterInterface;

class CsvExporter implements DataParserAdapterInterface {

    private $data;
    public function processData(): string
    {
    }

    public function returnOutput($inputData): string
    {
        $this->data = $inputData;
        return $this->processData();
    }
}