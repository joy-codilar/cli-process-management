<?php

namespace Codilar\CliProcessManagement\Controller\Adminhtml\Command;

use Codilar\CliProcessManagement\Model\CommandService;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Log extends Action
{
    const ADMIN_RESOURCE = 'Codilar_CliProcessManagement::all';

    private Context $context;
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
        $this->context = $context;
        $this->commandService = $commandService;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $data = [
            'data' => $this->commandService->getCommandLog(1000)
        ];
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response->setData($data);
        return $response;
    }
}
