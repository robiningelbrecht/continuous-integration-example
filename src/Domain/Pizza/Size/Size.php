<?php

namespace App\Domain\Pizza\Size;

use Money\Money;

interface Size
{
    public function getPrice(): Money;

    /**
     * @return string[]
     */
    public function getDescription(): array;
}
