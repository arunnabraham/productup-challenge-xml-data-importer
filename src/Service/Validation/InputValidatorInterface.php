<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Validation;

interface InputValidatorInterface
{
    public function definedValidatonSchema(): static;
    public function getSchema();
}
