<?php

declare(strict_types=1);

namespace Tests\Unit;

use Arunnabraham\XmlDataImporter\Service\Formats\JsonExporter;
use Arunnabraham\XmlDataImporter\Service\Metadata\WriteMetadataNdJSONService;
use PHPUnit\Framework\TestCase;

class JSONExporterTest extends TestCase
{
    private string $outFilePath;
    private string $metaFilePath;
    const TOTAL_RECORDS = 100;

    protected function setUp(): void
    {
        $this->metaFilePath = $_ENV['DEFAULT_DIR_PATH'] . '/xml-samples/employee.ndjson';
        $this->outFilePath = $_ENV['DEFAULT_DIR_PATH'] . '/xml-samples/employee_test.json';
        $this->removeTestFilesIFExists();
    }

    //Start Test cases
    public function testdoesOuputFile(): void
    {
        $this->performJSONOut();
        $this->assertFileExists($this->outFilePath, 'File does not exists');
    }

    public function testIsOutfileIsCSV(): void
    {
        $this->performJSONOut();
        $fp = fopen($this->outFilePath, 'r');
        $i=0;
        $str = '';
        while(!feof($fp))
        {
            //$rowLength = strlen(trim(fgets($fp)));
           $str .= fgets($fp);
        }
        $this->assertJson($str, 'Invalid Json output');

    }
    //End Test cases

    private function createFakeMeta()
    {

        $metafile = fopen($this->metaFilePath, 'w');
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < (self::TOTAL_RECORDS); $i++) {
            (new WriteMetadataNdJSONService($i, [
                'name' => $faker->name,
                'age' => $faker->numberBetween(1, 99),
                'phone' => $faker->phoneNumber()
            ]))
                ->writeRowDataToStream($metafile);
        }
        fclose($metafile);
    }

    private function removeTestFilesIFExists()
    {
        if (file_exists($this->outFilePath)) {
            unlink($this->outFilePath);
        }
        if (file_exists($this->metaFilePath)) {
            unlink($this->metaFilePath);
        }
    }

    private function performJSONOut()
    {
        $this->createFakeMeta();
        $fileOutput = fopen($this->outFilePath, 'w');
        $metaRead = fopen($this->metaFilePath, 'r');
        (new JsonExporter)->coreFormatAndWrite($metaRead, $fileOutput, $this->outFilePath);
        fclose($metaRead);
        fclose($fileOutput);
    }
}
