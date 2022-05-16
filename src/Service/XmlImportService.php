<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Arunnabraham\XmlDataImporter\Service\Formats\CsvExporter;

class XmlImportService
{

    public string $outputDir;
    private DataParserAdapterInterface $exportDriver;
    private $outputFilePrefix = 'data_';

    const EXPORT_FORMATS = [
        'csv' => CsvExporter::class,
        'json' => JsonExporter::class
    ];

    public function processImport($exportFormat, string $inputFile, string $outputDir, string $inputType = 'local')
    {
        try {
            $this->exportFormat = $exportFormat;
            $this->outputDir = $outputDir;
            $this->setDriver($this->exportFormat);
            if (empty($this->outputDir)) {
                throw new \Exception('Invalid File Ouptut');
            }
            if ((new XmlValidatorService)->validateXml($inputFile, $inputType)) {
              return $this->runExport();
            } else {
                throw new \Exception('Invalid XML Input');
            }
        } catch (\Exception $e) {
        }
    }

    private function runExport(): string
    {
        return (new XmlExportService)->exportData($this->exportDriver, $this->outputDir, $this->outputFilePrefix . '_' . uniqid() . '.' . strtolower($this->exportFormat));
    }

    private function setDriver($format): void
    {
        $this->exportDriver = self::EXPORT_FORMATS[$format];
    }
}
