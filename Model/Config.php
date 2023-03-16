<?php

namespace Codilar\CliProcessManagement\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isAppendLogFileReadingCommand(): bool
    {
        return $this->getValue('cli_process_management/general/append_log_file_reading_command') == 1;
    }

    /**
     * @return int
     */
    public function getLogFileNumberOfLinesToTail(): int
    {
        return abs(intval($this->getValue('cli_process_management/general/log_file_number_of_lines_to_tail')));
    }

    public function getValue($path, $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->scopeConfig->getValue($path, $scopeType, $scopeCode);
    }
}
