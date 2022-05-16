<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Formats;

use Arunnabraham\XmlDataImporter\Service\DataParserAdapterInterface as ServiceDataParserAdapterInterface;
use Arunnabraham\XmlDataImporter\Service\ExportIO\DisplayFormatIO;

class CsvExporter implements ServiceDataParserAdapterInterface
{

    private string $exportfileLocation;
    public function returnExportOutput($exportLocation, $inputResource): string
    {
        $this->exportfileLocation = $exportLocation;
        if ($this->processData($inputResource)) {
            return $this->exportFileLocation;
        }
        return null;
    }
    public function processData($inputResource): bool
    {
        return $this->exportCSV($inputResource);
    }

    private function exportCSV($sourceResource): bool
    {
        try {

            $destinationResource = fopen($this->exportfileLocation, 'w');
            $isFirstLine = true;
            if (!is_resource($destinationResource)) {
                throw new \Exception('Invalid Destination Resouces');
            }
            if (!is_resource($sourceResource)) {
                throw new \Exception('Invalid Source Resouce');
            }
            rewind($sourceResource);
            while (!feof($sourceResource)) {
                $data = json_decode(fgets($sourceResource), true);
                if (!empty($data)) {
                    $callArrayFn = $isFirstLine ? 'array_keys' : 'array_values';
                    $fputStatus = fputcsv($destinationResource, $callArrayFn($data));
                    if ($isFirstLine) {
                        //Insert initial values
                        fputcsv($destinationResource, array_values($data));
                    }
                    if ($fputStatus === false) {
                        throw new \Exception('Error in csv processing');
                    }
                    $isFirstLine = false;
                }
            }
        } catch (\Exception $e) {
            return false;
        }
        fclose($destinationResource);
        return true;
    }
}
