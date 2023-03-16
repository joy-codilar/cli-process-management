<?php

namespace Codilar\CliProcessManagement\Console\Command;

use Codilar\CliProcessManagement\Model\CommandService;
use Magento\Framework\Exception\NoSuchEntityException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CliCommandRun extends Command
{

    const COMMAND = 'cli:command:run';

    private CommandService $commandService;

    /**
     * @param CommandService $commandService
     * @param string|null $name
     */
    public function __construct(
        CommandService $commandService,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->commandService = $commandService;
    }

    protected function configure()
    {
        $this->setName(static::COMMAND);
        $this->setDescription(__('Run a CLI command defined in the CLI Process Management module'));
        $this->addOption('command', 'c', InputOption::VALUE_REQUIRED, __('The command ID'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandId = $input->getOption('command');
        if (!$commandId) {
            throw new NoSuchEntityException(__('Command is required'));
        }
        if ($this->commandService->executeCommand($commandId)) {
            $output->writeln(__('Command executed successfully'));
        } else {
            throw new NoSuchEntityException(__('Command "%1" not found', $commandId));
        }
    }
}
