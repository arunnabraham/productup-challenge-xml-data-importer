<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\XMLImportExport;

use Arunnabraham\XmlDataImporter\Service\ExportDriver\DataParserAdapterInterface as ExportDataParserAdapterInterface;
use Arunnabraham\XmlDataImporter\Service\XMLParser\ProcessXML;

class XmlExportService
{
    private string $processMode;
    public function setFileProcessMode($processMode): void
    {
        $this->processMode = $processMode;
    }

    public function exportData(ExportDataParserAdapterInterface $exportAdapter, $inputFile, string $outputDir, string $filename): string|bool
    {
        try {
            $reader = new \XMLReader;
            $reader->open($inputFile);
            $fp = $this->getFileProcessMode();
            if (!is_resource($fp)) {
                throw new \Exception('Invalid Resource');
            }
            while ($reader->read()) {
                $node = $reader->expand();
                (new ProcessXML())->processExport($node, $fp);
                $reader->next();
            }
            $reader->close();
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755);
            }
            $destination = $exportAdapter->returnExportOutput($outputDir . '/' . $filename, $fp);
            fclose($fp);
            return $destination;
        } catch (\Exception $e) {
            appLogger('error', 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString());
            return false;
        }
        return false;
    }

     /**
     * @return false|resource
     */
    public function getFileProcessMode()
    {
        return match ($this->processMode) {
            'MEMORY' => fopen('php://memory', 'rw'),
            default => tmpfile()
        };
    }
}
