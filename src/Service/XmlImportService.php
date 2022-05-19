<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Arunnabraham\XmlDataImporter\Service\Formats\{
    CsvExporter,
    JsonExporter
};
use Exception;
use Monolog\Logger;

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

    public function processImport(string $exportFormat, string $outputDir): string
    {
        try {
            $this->exportFormat = $exportFormat;
            $this->outputDir = $outputDir;
            $this->setDriver($this->exportFormat);
            if (empty($this->outputDir)) {
                throw new \Exception('Invalid File Ouptut');
            }
            $inputStream = (new ImportStdinHandler)->recieveAndWriteTempOfInputStream();
            if (!is_resource($inputStream)) {
                throw new Exception('Uknown input');
            }
            $this->inputFile = stream_get_meta_data($inputStream)['uri'];
            if ((new XmlValidatorService)->validateXml($this->inputFile)) {
                $exportResponse = $this->runExport();
                if (!is_string($exportResponse)) {
                    throw new Exception('Unknow Error in Export');
                }
                return (new DisplayExportOutputFileFormat)->response($exportResponse);
            } else {
                throw new \Exception('Invalid XML Input');
            }
        } catch (\Exception $e) {
            appLogger('error', 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString());
            return 'Error: ' . $e->getMessage();
        }
    }

    private function runExport(): string
    {
        $exportService =  new XmlExportService;
        $exportService->setFileProcessMode(env('PROCESS_MODE'));
        return $exportService->exportData($this->exportDriver, $this->inputFile, $this->outputDir, $this->outputFilePrefix . '_' . uniqid() . '.' . strtolower($this->exportFormat));
    }

    private function setDriver($format): void
    {
        $this->exportDriver = (new (self::EXPORT_FORMATS[strtolower($format)])());
    }
}
