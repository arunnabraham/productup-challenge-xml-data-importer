<?php

declare(strict_types=1);

namespace Tests\Unit;

use Arunnabraham\XmlDataImporter\Modules\Export\XMLImportExport\XMLImportExportCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Dotenv\Dotenv;

class ConsoleXMLImportExportCommandTest extends TestCase
{
    private $consoleValidation = null;

    /*public function testValidateForConsoleInputCsvFormat(): void
    {
        $commandName = 'export';
        $exportFormat = 'csv';
        $tester = $this->consoleInputHandler($commandName, ['exportformat' => $exportFormat]);
        $this->assertStringStartsWith('Export File:', $tester->getDisplay(), 'Invalid Console Input');
        //  return;
    }

    public function testValidateForConsoleInputJsonFormat(): void
    {
        $commandName = 'export';
        $exportFormat = 'json';
        $testerOutput = $this->consoleInputHandler($commandName, ['exportformat' => $exportFormat]);
        $this->assertStringStartsWith('Export File:', $testerOutput->getDisplay(), 'Invalid Console Input');
        //  return;
    }

    private function consoleInputHandler($commandName, array $arguments = []): CommandTester
    {
        $application = new \Symfony\Component\Console\Application();

        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env');
        $createdCommand = new XMLImportExportCommand();
        $application->add($createdCommand);
        $foundCommand = $application->find($commandName);
        $tester = new \Symfony\Component\Console\Tester\CommandTester($foundCommand);
        $commandStream = array_merge([
            'command' => $commandName
        ], $arguments);
        $tester->execute($commandStream);
        array_map('fclose', get_resources('stream'));
        return $tester;
    }

    public function __destruct()
    {
        array_map('fclose', get_resources('stream'));
    }  */
}
