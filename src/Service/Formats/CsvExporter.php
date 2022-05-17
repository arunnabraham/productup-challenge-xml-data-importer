<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Formats;

use Exception;

class CsvExporter extends GenericExport
{

    protected string $exportFileLocation;

    public function coreFormatAndWrite($sourceResource, $destinationResource = null, $destinatonPath = ''): void
    {
        try {
            $isFirstSeek = true;
            while (!feof($sourceResource)) {
                $data = json_decode(fgets($sourceResource), true);
                if (!empty($data)) {
                    $callArrayFn = $isFirstSeek ? 'array_keys' : 'array_values';
                    $fputStatus = fputcsv($destinationResource, $callArrayFn($data));
                    if ($isFirstSeek) {
                        //Insert initial values
                        fputcsv($destinationResource, array_values($data));
                    }
                    if ($fputStatus === false) {
                        throw new \Exception('Error in csv processing');
                    }
                    $isFirstSeek = false;
                }
            }
        } catch (Exception $e) {
            appLogger('error', 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString());
        }
    }
}
