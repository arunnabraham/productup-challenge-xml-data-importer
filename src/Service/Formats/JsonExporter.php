<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Formats;

class JsonExporter extends GenericExport
{

    protected string $exportFileLocation;

    public function coreFormatAndWrite($sourceResource, $destinationResource = null, $destinatonPath = ''): void
    {
        $isFirstSeek = true;
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
    }
}
