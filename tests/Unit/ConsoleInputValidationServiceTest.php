<?php

declare(strict_types=1);

namespace Tests\Unit;

use Arunnabraham\XmlDataImporter\Modules\Export\XMLImportExport\XMLImportExportValidatorConfig;
use Arunnabraham\XmlDataImporter\Service\Validation\ConsoleInputValidationService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;

class ConsoleInputValidationServiceTest extends TestCase
{

    protected function setUp(): void
    {
    }

    //Start Test cases
    private function getInputs(string $format): Input
    {
        
        $mockInputDefinition = $this->createMock(InputDefinition::class);
        $mockInputDefinition->setDefinition([
            new InputArgument('exportformat', 1, '')
        ]);
        $mockArrayInput = $this->createMock(ArrayInput::class);
        //$mockArrayInput->bind($mockInputDefinition);
        $mockArrayInput->__construct([
            'exportformat' => $format,
            'command' => 'export'
        ], $mockInputDefinition);
        return $mockArrayInput;
    }
    public function testdoesArgumentsValidated(): void
    {
        $inputsForValidation = (new ConsoleInputValidationService(
            (new XMLImportExportValidatorConfig)
        ))->validateArguments($this->getInputs('json'));
        $this->assertTrue($inputsForValidation->isValid(), 'Cannot validate input validation');
    }

    public function tesdoesErrorMessagesisArray(): void
    {
        $inputsForValidation = (new ConsoleInputValidationService(
            (new XMLImportExportValidatorConfig)
        ))->validateArguments($this->getInputs('json'));

        $this->assertIsArray($inputsForValidation->getValidationErrorMessages());
    }
    //End Test cases


}
