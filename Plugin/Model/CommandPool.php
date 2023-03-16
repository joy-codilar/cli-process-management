<?php

namespace Codilar\CliProcessManagement\Plugin\Model;

use Codilar\CliProcessManagement\Model\CommandPool as Subject;
use Codilar\CliProcessManagement\Model\Command\AbstractCommandFactory;
use Codilar\CliProcessManagement\Model\Config;
use Magento\Framework\App\Filesystem\DirectoryList;

class CommandPool
{
    private AbstractCommandFactory $abstractCommandFactory;
    private DirectoryList $directoryList;
    private Config $config;

    /**
     * @param AbstractCommandFactory $abstractCommandFactory
     * @param DirectoryList $directoryList
     * @param Config $config
     */
    public function __construct(
        AbstractCommandFactory $abstractCommandFactory,
        DirectoryList $directoryList,
        Config $config
    )
    {
        $this->abstractCommandFactory = $abstractCommandFactory;
        $this->directoryList = $directoryList;
        $this->config = $config;
    }

    protected function getLogFileCommands(): array
    {
        try {
            $varLogDirectory = $this->directoryList->getPath('var') . '/log';
            $rootDirectory = $this->directoryList->getRoot();
            $logFiles = glob($varLogDirectory . '/*.log');
            $isAppendLogFileReadingCommand = $this->config->isAppendLogFileReadingCommand();
            $numberOfLinesToRead = $this->config->getLogFileNumberOfLinesToTail();
            $response = [];
            if ($isAppendLogFileReadingCommand) {
                foreach ($logFiles as &$logFile) {
                    $logFile = trim(str_replace($rootDirectory, '', $logFile), '/');
                    $response['read-log-file-' . $logFile] = $this->abstractCommandFactory->create([
                        'name' => __('Read %1 log file', $logFile),
                        'description' => __('Read the last %1 lines of %2', $numberOfLinesToRead, $logFile),
                        'command' => sprintf('tail -%s %s', $numberOfLinesToRead, $logFile)
                    ]);
                }
            }
            return $response;
        } catch (\Exception) {
            return [];
        }
    }

    public function afterGetCommands(Subject $subject, $result)
    {
        foreach ($this->getLogFileCommands() as $key => $command) {
            $result[$key] = $command;
        }
        return $result;
    }

}
