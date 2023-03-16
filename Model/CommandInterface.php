<?php

namespace Codilar\CliProcessManagement\Model;

interface CommandInterface
{
    public function getName(): string;

    public function getDescription(): string;

    public function getCommand(): string;
}
