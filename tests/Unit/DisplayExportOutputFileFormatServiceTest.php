<?php

declare(strict_types=1);

namespace Tests\Unit;

use Arunnabraham\XmlDataImporter\Service\IO\DisplayExportOutputFileFormatService;
use PHPUnit\Framework\TestCase;

class DisplayExportOutputFileFormatServiceTest extends TestCase
{
    public function testResponseGivesFileUri()
    {
        $filePath = '/home/test/return.json';
        $result = (new DisplayExportOutputFileFormatService)->response($filePath);
        $this->assertSame('file://'.$filePath, $result);
    }

    public function testHttpResponseGivesHttpUri()
    {
        $filePath = 'http://support.oneskyapp.com/hc/en-us/article_attachments/202761627/example_1.json';
        $result = (new DisplayExportOutputFileFormatService)->response($filePath);
        $this->assertSame($filePath, $result);
    }

    public function testHttpsResponseGivesHttpsUri()
    {
        $filePath = 'https://support.oneskyapp.com/hc/en-us/article_attachments/202761627/example_1.json';
        $result = (new DisplayExportOutputFileFormatService)->response($filePath);
        $this->assertSame($filePath, $result);
    }
}
