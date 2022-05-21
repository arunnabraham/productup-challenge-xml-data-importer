<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Modules\Export\XMLImportExport;

use Arunnabraham\XmlDataImporter\Service\Validation\InputValidatorInterface;

class XMLImportExportValidatorConfig implements InputValidatorInterface
{
    private array $schema;
    public function definedValidatonSchema(): XMLImportExportValidatorConfig
    {
        $this->schema = [
            //Input Category
            'arguments' => [
                //Argument Key
                'exportformat' =>
                //Validation callback
                function ($input): array {
                    return [
                        [
                             //Validate with callbacks that always array with bool and string for error
                            in_array($input, ['csv', 'json'], true),
                            'Invalid export format: ' . $input
                        ],
                        // validation arrays ... ...
                    ];
                }
            ]

        ];
        return $this;
    }

    public function getSchema(): array
    {
        return $this->schema;
    }
}
