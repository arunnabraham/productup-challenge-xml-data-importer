<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\ExportIO;

class DisplayFormatIO
{
    private string $preOutputData;
    public function __construct(mixed $preOutputData)
    {
        $this->dataInfo = $preOutputData;
    }
    public function displayAsRaw(): string
    {
        return $this->dataInfo;
    }

    public function displayAsFileLocation($path): string
    {
    }
}
