<?php

namespace Codilar\CliProcessManagement\Model;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\App\Filesystem\DirectoryList;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessFactory;

class CommandService
{

    const COMMAND_LOG_FILE = 'command_log_file';

    private DirectoryList $directoryList;
    private ProcessFactory $processFactory;
    private CommandPool $commandPool;

    /**
     * @param DirectoryList $directoryList
     * @param ProcessFactory $processFactory
     * @param CommandPool $commandPool
     */
    public function __construct(
        DirectoryList $directoryList,
        ProcessFactory $processFactory,
        CommandPool $commandPool
    ) {
        $this->directoryList = $directoryList;
        $this->processFactory = $processFactory;
        $this->commandPool = $commandPool;
    }

    /**
     * @param string $commandId
     * @return bool
     */
    public function executeCommand(string $commandId): bool
    {
        $command = $this->commandPool->getCommand($commandId);
        if ($command) {
            $this->executeCommandRaw($command->getCommand(), \Closure::fromCallable([$this, 'logProcessOutput']));
            return true;
        }
        return false;
    }

    /**
     * @param string $command
     * @param callable|null $callback
     * @return Process
     */
    public function executeCommandRaw(string $command, ?callable $callback = null): Process
    {
        $process = $this->processFactory->create([
            'command' => $command
        ]);
        $process->setWorkingDirectory($this->directoryList->getRoot());
        $process->run($callback);
        return $process;
    }

    protected function logProcessOutput($type, $buffer): void
    {
        $logFilePath = $this->getLogFilePath();
        $fp = fopen($logFilePath, 'a');
        fwrite($fp, $buffer);
        fclose($fp);
    }

    public function truncateCommandLog(): void
    {
        $logFilePath = $this->getLogFilePath();
        if (file_exists($logFilePath)) {
            unlink($logFilePath);
        }
    }

    /**
     * @param int|null $lines
     * @return string
     */
    public function getCommandLog(?int $lines): string
    {
        $filePath = $this->getLogFilePath();
        if (file_exists($filePath)) {
            $file = new \SplFileObject($filePath, 'r');
            $file->seek(PHP_INT_MAX);
            $lastLine = $file->key();
            if (!$lines || $lines > $lastLine) {
                $lines = $lastLine;
            }
            $lines = new \LimitIterator($file, $lastLine - $lines, $lastLine);
            return implode('', iterator_to_array($lines));
        } else {
            return '';
        }
    }

    /**
     * @return string|null
     */
    public function getLogFilePath(): ?string
    {
        try {
            return $this->directoryList->getPath('var') . '/log/' . static::COMMAND_LOG_FILE . '.txt';
        } catch (FileSystemException $e) {
            return null;
        }
    }
}
