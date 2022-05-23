<?php

declare(strict_types=1);

namespace Tests\Unit;

use Arunnabraham\XmlDataImporter\Service\Formats\CsvExporter;
use Arunnabraham\XmlDataImporter\Service\Formats\JsonExporter;
use Arunnabraham\XmlDataImporter\Service\XMLImportExport\XmlExportService;
use PHPUnit\Framework\TestCase;

class XmlExportServiceTest extends TestCase
{
    private $samplingPath;
    const FORMAT = 'csv';

    protected function setUp(): void
    {
        $this->samplingPath = $_ENV['DEFAULT_DIR_PATH'] . '/xml-samples';
    }

    //Start Test cases
    private function runExport(): string|null|bool
    {
        try {
            $format = [
                'csv' => CsvExporter::class,
                'json' => JsonExporter::class
            ];
            $selectedDriver = (new $format[strtolower(self::FORMAT)]);
            $xmlExportService = new XmlExportService;
            $xmlExportService->setFileProcessMode($_ENV['PROCESS_MODE']);
            return $xmlExportService
                ->exportData(
                    $selectedDriver,
                    $this->samplingPath . '/employee.xml',
                    $this->samplingPath,
                    'emplyee_test.' . self::FORMAT
                );
        } catch (\Throwable $e) {
            echo $e->getMessage();
            return false;
        }
        return null;
    }

    public function testCanReturnString(): void
    {
        $this->assertIsString($this->runExport());
    }

    public function testFileExists(): void
    {
        $this->assertFileExists($this->runExport());
    }

    public function testDoesOutputFileHasValidFormat()
    {
        $this->assertEquals(self::FORMAT, pathinfo($this->runExport(), PATHINFO_EXTENSION));
    }
}
