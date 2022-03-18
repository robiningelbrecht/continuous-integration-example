<?php

namespace App\Domain\Pizza\Size;

use Money\Money;

class Large implements Size
{
    public function getPrice(): Money
    {
        return Money::EUR(1000);
    }

    public function getDescription(): array
    {
        return ['Medium pizza'];
    }
}
