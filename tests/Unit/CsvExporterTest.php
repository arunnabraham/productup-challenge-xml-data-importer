<?php

declare(strict_types=1);

namespace Tests\Unit;

use Arunnabraham\XmlDataImporter\Service\Formats\CsvExporter;
use Arunnabraham\XmlDataImporter\Service\XMLImportExport\XmlExportService;
use Arunnabraham\XmlDataImporter\Service\XMLParser\ProcessXML;
use PHPUnit\Framework\TestCase;

class CsvExporterTest extends TestCase
{
    private string $inFilePath;
    private string $outFilePath;
    private string $metaFilePath;
    const TOTAL_RECORDS = 100;
    public function __construct()
    {
        $this->inFilePath = $_ENV['DEFAULT_DIR_PATH'] . '/xml-samples/employee.xml';
        $this->metaFilePath = $_ENV['DEFAULT_DIR_PATH'] . '/xml-samples/employee.ndjson';
        $this->outFilePath = $_ENV['DEFAULT_DIR_PATH'] . '/xml-samples/employee_test.csv';
        $this->performCSVOut();
    }

    private function performCSVOut()
    {
        $fileInput = fopen($this->inFilePath, 'r');
        $metafile = fopen($this->metaFilePath, 'w');
        $fileOutput = fopen($this->outFilePath, 'w');
        $faker = \Faker\Factory::create();
        while()
        (new ProcessXML)->writeMetadata()
        $ndjsonSample = json_encode(
            [
                'name' => $faker->name(),
                'age' => $faker->numberBetween(15, 99),
                'phone' => $faker->phoneNumber()
            ]
        );
        fputs($metafile, $ndjsonSample);
        //add records
        for ($i = 0; $i < (self::TOTAL_RECORDS-1); $i++) {
            $ndjsonSample .= PHP_EOL . json_encode(
                [
                    'name' => $faker->name(),
                    'age' => $faker->numberBetween(15, 99),
                    'phone' => $faker->phoneNumber()
                ]
            );
        }
        fputs();
        (new CsvExporter)->coreFormatAndWrite($fileInput, $fileInput, $this->outFilePath);
        fclose($fileInput);
        fclose($fileOutput);
    }
    public function testdoesOuputFile(): void
    {
        $this->assertFileExists($this->outFilePath, 'File does not exists');
    }
}
