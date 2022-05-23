<?php

declare(strict_types=1);

namespace Tests\Unit;

use Arunnabraham\XmlDataImporter\Service\XMLImportExport\XmlImportExportService;
use PHPUnit\Framework\TestCase;

/* 
Expecting input stream 
example cat filepath.xml | vendor/bin/phpunit
class XmlImportExportServiceTest extends TestCase
{
    private $samplingPath;
    const FORMAT = 'json';

    protected function setUp(): void
    {
        $this->samplingPath = $_ENV['DEFAULT_DIR_PATH'] . '/xml-samples';
        $this->processInput = [
            self::FORMAT,
            $this->samplingPath
        ];
    }

    //Start Test cases
    private function service(): XmlImportExportService|null|bool
    {
        try {
            $importExportService = new XmlImportExportService;
            return $importExportService;
        } catch (\Throwable $e) {
            echo $e->getMessage();
            return false;
        }
        return null;
    }

    public function testCanReturnString(): void
    {
        $args = $this->processInput;
        $this->assertIsString($this->service()->processImport(
            ...$args
        ));
    }

    public function testFileExists(): void
    {
        $args = $this->processInput;
        $this->assertFileExists($this->service()->processImport(
            ...$args
        ));
    }

    public function testDoesOutputFileHasValidFormat()
    {
        $args = $this->processInput;
        $this->assertEquals(self::FORMAT, pathinfo($this->service()->processImport(
            ...$args
        ), PATHINFO_EXTENSION));
    }

    public function testInvalidExportFormat()
    {
        $args = $this->processInput;
        $this->assertNotEquals(false, $this->service()->processImport(
            ...$args
        ), 'Uknown Process Error');
    }
}
*/
