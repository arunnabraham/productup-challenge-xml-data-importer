<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Validation;

use Symfony\Component\Console\Input\InputInterface;

class ConsoleInputValidationService
{
    private InputValidatorInterface $validationConfig;
    private array $invalidInfo = [];
    private bool $isValid = false;
    public function __construct(InputValidatorInterface $validationConfig)
    {
        $this->validationConfig = $validationConfig;
    }
    public function validateArguments(InputInterface $input): ConsoleInputValidationService
    {
        try {
            $validations = [];
            $validationSchema = $this->validationConfig->definedValidatonSchema()->getSchema();
            foreach ($input->getArguments() as $argKey => $argValue) {
                $validations[] = array_map(function ($invalidated) {
                    return $invalidated[1] ?? '';
                }, array_filter(is_callable($validationSchema['arguments'][$argKey] ?? []) ? $validationSchema['arguments'][$argKey]($argValue) : [], function ($value) {
                    return !empty($value) && !$value[0];
                }));
            }
            $this->invalidInfo = array_values(array_filter($validations, fn ($error) => !empty($error)));
            $this->isValid = empty($this->invalidInfo);
        } catch (\Exception $e) {
            return null;
        }
        return $this;
    }
    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getValidationErrorMessages(): array
    {
        return $this->invalidInfo;
    }
}
