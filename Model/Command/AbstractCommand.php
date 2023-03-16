<?php

namespace Codilar\CliProcessManagement\Model\Command;

use Codilar\CliProcessManagement\Model\CommandInterface;

class AbstractCommand implements CommandInterface
{
    private string $name;
    private string $description;
    private string $command;

    /**
     * @param string $name
     * @param string $description
     * @param string $command
     */
    public function __construct(
        string $name,
        string $description,
        string $command
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->command = $command;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCommand(): string
    {
        return $this->command;
    }
}
