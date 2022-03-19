<?php

namespace App\Domain\Pizza\Topping;

use Money\Money;

class Ham extends BaseTopping
{
    protected function giveMeThePrice(): Money
    {
        return Money::EUR(75);
    }

    protected function giveMeTheDescription(): string
    {
        return 'Ham';
    }
}
