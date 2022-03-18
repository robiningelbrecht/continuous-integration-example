<?php

namespace App\Domain\Pizza\Size;

use Money\Money;

class Small implements Size
{
    public function getPrice(): Money
    {
        return Money::EUR(600);
    }

    public function getDescription(): array
    {
        return ['Medium pizza'];
    }
}
