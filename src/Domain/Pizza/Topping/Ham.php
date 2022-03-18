<?php

namespace App\Domain\Pizza\Topping;

use Money\Money;

class Ham extends Topping
{
    protected function giveMeThePrice(): Money
    {
        return Money::EUR(75);
    }

    protected function giveMeTheDescription(): array
    {
        return ['Ham'];
    }
}
