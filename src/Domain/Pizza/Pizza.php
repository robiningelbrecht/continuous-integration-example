<?php

namespace App\Domain\Pizza;

use Money\Money;

interface Pizza extends \JsonSerializable
{
    public function getPrice(): Money;

    /**
     * @return string[]
     */
    public function getDescription(): array;
}
