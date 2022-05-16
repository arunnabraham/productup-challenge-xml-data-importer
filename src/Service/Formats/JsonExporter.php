<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Formats;

use Arunnabraham\XmlDataImporter\Service\DataParserAdapterInterface as ServiceDataParserAdapterInterface;

class JsonExporter implements ServiceDataParserAdapterInterface
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
        return $this->exportJson($inputResource);
    }

    private function exportJson($sourceResource): bool
    {
        try {
            $location = $this->exportfileLocation;
            if(file_exists($location))
            {
                unlink($location);
            }
            $destinationResource = fopen($location, 'a');
            $isFirstSeek = true;
            if (!is_resource($destinationResource)) {
                throw new \Exception('Invalid Destination Resouces');
            }
            if (!is_resource($sourceResource)) {
                throw new \Exception('Invalid Source Resouce');
            }
            rewind($sourceResource);
            while (!feof($sourceResource)) {
                $data = fgets($sourceResource);
                if ($isFirstSeek) {
                    $delimiter = '[';
                } else {
                    $delimiter = ',';
                }
                fwrite($destinationResource, $delimiter . $data);
                $isFirstSeek = false;
            }
            fwrite($destinationResource, ']');
        } catch (\Exception $e) {
            return false;
        }
        fclose($destinationResource);
        return true;
    }
}
