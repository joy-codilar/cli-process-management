<?php

namespace Codilar\CliProcessManagement\Controller\Adminhtml\Command;

use Codilar\CliProcessManagement\Model\CommandService;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class TruncateLog extends Action
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
        $this->commandService->truncateCommandLog();
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData(['status' => true]);
    }
}
