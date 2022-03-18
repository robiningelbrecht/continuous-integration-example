<?php

namespace App\Domain\Pizza\Crust;

use Money\Money;

class ThickCrust implements Crust
{
    public function getPrice(): Money
    {
        return Money::EUR(200);
    }

    public function getDescription(): array
    {
        return ['Thick crust'];
    }
}
