<?php
declare(strict_types=1);
namespace Arunnabraham\XmlDataImporter\Service\Validation;

use Symfony\Component\Console\Input\InputInterface;

interface InputValidationInterface {
    public function validateArguments(InputInterface $input):void;
    public function setValidatorConfig(array $config): void;
    public function validate(): bool;
}