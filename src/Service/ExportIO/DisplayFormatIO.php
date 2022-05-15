<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\ExportIO;

class DisplayFormatIO
{
    private string $preOutputData;
    private string $outputPath;

    public function displayFileLocation($path=''): string
    {
        return $path;
    }
}
