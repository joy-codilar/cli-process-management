<?php

namespace Codilar\CliProcessManagement\Controller\Adminhtml\Command;

use Codilar\CliProcessManagement\Model\CommandService;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;

class DownloadLog extends Action
{

    const ADMIN_RESOURCE = 'Codilar_CliProcessManagement::all';
    private CommandService $commandService;
    private FileFactory $fileFactory;

    /**
     * @param Context $context
     * @param CommandService $commandService
     * @param FileFactory $fileFactory
     */
    public function __construct(
        Context $context,
        CommandService $commandService,
        FileFactory $fileFactory
    )
    {
        parent::__construct($context);
        $this->commandService = $commandService;
        $this->fileFactory = $fileFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $logFile = $this->commandService->getLogFilePath();
        if (file_exists($logFile)) {
            $content = [
                'type' => 'filename',
                'value' => $logFile
            ];
        } else {
            $content = '';
        }
        return $this->fileFactory->create(
            sprintf('%s_%s.log', CommandService::COMMAND_LOG_FILE, date('Y-m-d')),
            $content
        );
    }
}
