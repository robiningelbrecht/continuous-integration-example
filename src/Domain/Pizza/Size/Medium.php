<?php

namespace App\Domain\Pizza\Size;

use Money\Money;

class Medium implements Size
{
    public function getPrice(): Money
    {
        return Money::EUR(850);
    }

    public function getDescription(): array
    {
        return ['Medium pizza'];
    }
}
