<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Modules\Export\XMLImportExport;

use Arunnabraham\XmlDataImporter\Service\Validation\ConsoleInputValidationService;
use Arunnabraham\XmlDataImporter\Service\XMLImportExport\XmlImportExportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class XMLImportExportCommand extends Command
{
    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('export')
            ->setDescription('Runs XML Export to various formats')
            ->addArgument('exportformat', InputArgument::REQUIRED, 'Input export format eg: csv or json');
    }

    /**
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $validation =
            (new ConsoleInputValidationService(new XMLImportExportValidatorConfig))
            ->validateArguments($input);

        if ($validation->isValid()) {
            $processImportExport = (new XmlImportExportService())->processImport(
                $input->getArgument('exportformat'),
                env('DEFAULT_OUTPUT_DIR_PATH')
            );
            if (str_contains($processImportExport, 'Error')) {
                $output->writeln(sprintf('<comment>%s</comment>', $processImportExport));
            } else {
                $output->writeln('<info>Export File:</info>' . PHP_EOL);
                $output->writeln(sprintf('%s', $processImportExport . PHP_EOL));
            }
        } else {
            if (!empty($validation->getValidationErrorMessages())) {
                $output->writeln(sprintf('<error>%s</error>', 'Input validation errors:' . PHP_EOL));
                foreach ($validation->getValidationErrorMessages() as $validatonMessages) {
                    $output->writeln(sprintf('<comment>%s</comment>', implode(PHP_EOL, $validatonMessages)));
                }
            }
        }
        return 0;
    }
}
