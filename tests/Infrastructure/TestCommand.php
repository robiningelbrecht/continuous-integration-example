<?php

namespace App\Tests\Infrastructure;

use App\Infrastructure\DomainCommand;

class TestCommand extends DomainCommand
{
    /**
     * @param string[] $secondParam
     */
    public function __construct(
        protected string $firstParam,
        protected array $secondParam,
    ) {
    }
}
