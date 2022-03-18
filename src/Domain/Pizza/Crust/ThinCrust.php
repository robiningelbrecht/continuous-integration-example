<?php

namespace App\Domain\Pizza\Crust;

use Money\Money;

class ThinCrust implements Crust
{
    public function getPrice(): Money
    {
        return Money::EUR(150);
    }

    public function getDescription(): array
    {
        return ['Thin crust'];
    }
}
