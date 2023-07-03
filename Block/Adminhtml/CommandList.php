<?php

namespace Codilar\CliProcessManagement\Block\Adminhtml;

use Codilar\CliProcessManagement\Model\CommandInterface;
use Codilar\CliProcessManagement\Model\CommandPool;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;

class CommandList extends Template
{
    protected $_template = 'Codilar_CliProcessManagement::command_list.phtml';

    private CommandPool $commandPool;

    /**
     * @param Context $context
     * @param CommandPool $commandPool
     * @param array $data
     * @param JsonHelper|null $jsonHelper
     * @param DirectoryHelper|null $directoryHelper
     */
    public function __construct(
        Template\Context $context,
        CommandPool $commandPool,
        array $data = [],
        ?JsonHelper $jsonHelper = null,
        ?DirectoryHelper $directoryHelper = null
    )
    {
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
        $this->commandPool = $commandPool;
    }

    /**
     * @return CommandInterface[]
     */
    public function getCommands(): array
    {
        return $this->commandPool->getCommands();
    }

    public function getTableHeaders(): array
    {
        return [
            __('Name'),
            __('Description'),
            __('Command'),
            __('Action')
        ];
    }

    /**
     * @return string
     */
    public function getCommandLogUrl(): string
    {
        return $this->getUrl('*/*/log');
    }

    /**
     * @return string
     */
    public function getTruncateCommandLogUrl(): string
    {
        return $this->getUrl('*/*/truncateLog');
    }

    /**
     * @return string
     */
    public function getDownloadCommandLogUrl(): string
    {
        return $this->getUrl('*/*/downloadLog');
    }

    /**
     * @return string
     */
    public function getCommandExecuteUrl(): string
    {
        return $this->getUrl('*/*/execute');
    }
}
