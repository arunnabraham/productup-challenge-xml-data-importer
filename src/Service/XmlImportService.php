<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Arunnabraham\XmlDataImporter\Service\Formats\{
    CsvExporter,
    JsonExporter
};

class XmlImportService
{

    public string $outputDir;
    private DataParserAdapterInterface $exportDriver;
    private string $outputFilePrefix = 'data_';
    private string $inputFile;

    const EXPORT_FORMATS = [
        'csv' => CsvExporter::class,
        'json' => JsonExporter::class
    ];

    public function processImport($exportFormat, string $inputFile, string $outputDir, string $inputType = 'local'): string
    {
        try {
            $this->exportFormat = $exportFormat;
            $this->outputDir = $outputDir;

            $this->setDriver($this->exportFormat);
            if (empty($this->outputDir)) {
                throw new \Exception('Invalid File Ouptut');
            }
            if ((new XmlValidatorService)->validateXml($inputFile, $inputType)) {
                $this->inputFile = $inputFile;
                return $this->runExport();
            } else {
                throw new \Exception('Invalid XML Input');
            }
        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage();
        }
    }

    private function runExport(): string
    {
        //var_dump(env('PROCESS_MODE')); exit;
        $exportService =  new XmlExportService;
        $exportService->setFileProcessMode(env('PROCESS_MODE'));       
        return $exportService->exportData($this->exportDriver, $this->inputFile, $this->outputDir, $this->outputFilePrefix . '_' . uniqid() . '.' . strtolower($this->exportFormat));
    }

    private function setDriver($format): void
    {
        $this->exportDriver = (new (self::EXPORT_FORMATS[strtolower($format)])());
    }
}
