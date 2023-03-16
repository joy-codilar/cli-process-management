<?php

namespace Codilar\CliProcessManagement\Controller\Adminhtml\Command;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{

    const ADMIN_RESOURCE = 'Codilar_CliProcessManagement::all';

    /**
     * @inheritDoc
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
