<?php

namespace App\Domain\Pizza\Crust;

use Money\Money;

interface Crust
{
    public function getPrice(): Money;

    /**
     * @return string[]
     */
    public function getDescription(): array;
}
