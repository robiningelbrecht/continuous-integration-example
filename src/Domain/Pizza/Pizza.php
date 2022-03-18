<?php

namespace App\Domain\Pizza;

use Money\Money;

interface Pizza
{
    public function getPrice(): Money;

    /**
     * @return string[]
     */
    public function getDescription(): array;
}
