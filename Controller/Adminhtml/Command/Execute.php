<?php

namespace Codilar\CliProcessManagement\Controller\Adminhtml\Command;

use Codilar\CliProcessManagement\Console\Command\CliCommandRun;
use Codilar\CliProcessManagement\Model\CommandService;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Execute extends Action
{

    const ADMIN_RESOURCE = 'Codilar_CliProcessManagement::all';
    private CommandService $commandService;

    /**
     * @param Context $context
     * @param CommandService $commandService
     */
    public function __construct(
        Context $context,
        CommandService $commandService
    )
    {
        parent::__construct($context);
        $this->commandService = $commandService;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $commandId = $this->getRequest()->getParam('command_id');
        if ($commandId) {
            $command = 'bin/magento ' . CliCommandRun::COMMAND . ' --command="' . $commandId . '" >/dev/null 2>/dev/null &';
            $process = $this->commandService->executeCommandRaw($command);
            echo $process->getOutput();
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData(['status' => true]);
    }
}
