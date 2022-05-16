<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service;

use Arunnabraham\XmlDataImporter\Service\DataParserAdapterInterface as ExportDataParserAdapterInterface;
use Arunnabraham\XmlDataImporter\Service\XMLParser\ProcessXML;
use Exception;

class XmlExportService
{
    public $processMode;
    public function setFileProcessMode($processMode)
    {
        $this->processMode;
    }

    public function exportData(ExportDataParserAdapterInterface $exportAdapter, string $outputDir, string $filename): string|bool
    {
        try {
            $reader = new \XMLReader;
            $reader->open($this->inputFile);
            $fp = $this->getFileProcessMode();
            if (!is_resource($fp)) {
                throw new Exception('Invalid Resource');
            }
            while ($reader->read()) {
                $node = $reader->expand();
                (new ProcessXML())->processExport($node, $fp);
                $reader->next();
            }
            $reader->close();
            $destination = $exportAdapter->returnExportOutput($outputDir . '/' . $filename, $fp);
            fclose($fp);
            return $destination;
        } catch (\Exception $e) {
            //
            return false;
        }
        return false;
    }

    public function getFileProcessMode()
    {
        return match ($this->processMode) {
            'MEMORY' => fopen('php://memory', 'rw'),
            default => tmpfile()
        };
    }
}
