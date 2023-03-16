<?php

namespace Codilar\CliProcessManagement\Model;

class CommandPool
{
    /**
     * @var CommandInterface[]
     */
    private array $commands;

    /**
     * @param CommandInterface[] $commands
     */
    public function __construct(
        array $commands = []
    )
    {
        $this->commands = $commands;
    }

    /**
     * @return CommandInterface[]
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @param string $commandId
     * @return CommandInterface|null
     */
    public function getCommand(string $commandId): ?CommandInterface
    {
        return $this->getCommands()[$commandId] ?? null;
    }
}
