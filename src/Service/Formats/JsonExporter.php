<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Formats;

class JsonExporter extends GenericExport
{

    protected string $exportFileLocation;

    public function coreFormatAndWrite($sourceResource, $destinationResource = null, $destinatonPath = ''): void
    {
        try {
            $isFirstSeek = true;
            if(!is_resource($sourceResource))
            {
                throw new \Exception('Source resource is invalid');
            }
            if(!is_resource($destinationResource))
            {
                throw new \Exception('Destination resource is invalid');
            }
            while (!feof($sourceResource)) {
                $data = fgets($sourceResource);
                if ($isFirstSeek) {
                    $delimiter = '[';
                } else {
                    $delimiter = ',';
                }
                if ($destinationResource !== null) {
                    fwrite($destinationResource, $delimiter . $data);
                }
                $isFirstSeek = false;
            }
            fwrite($destinationResource, ']');
        } catch (\Exception $e) {
            appLogger('error', 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString());
        }
    }
}
