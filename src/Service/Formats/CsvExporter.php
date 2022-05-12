<?php
declare(strict_types=1);
namespace Arunnabraham\XmlDataImporter\Service\Formats;

use Arunnabraham\XmlDataImporter\Service\DataParserAdapterInterface as ServiceDataParserAdapterInterface;
use Arunnabraham\XmlDataImporter\Service\ExportIO\DisplayFormatIO;
use Symfony\Component\Serializer\Serializer;

class CsvExporter implements ServiceDataParserAdapterInterface {

    private $data;
    public function processData(): DisplayFormatIO
    {
       $dataDeserialized = (new Serializer)->deserialize($this->data, 'array', 'xml');
       // Convert to csv object
       return (new DisplayFormatIO)
    }

    public function returnOutput($inputData): string
    {
        $this->data = $inputData;
        return $this->processData();
    }
}