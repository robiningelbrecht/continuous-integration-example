<?php

namespace App\Domain\Pizza\Topping;

use Money\Money;

class ExtraCheese extends BaseTopping
{
    protected function giveMeThePrice(): Money
    {
        return Money::EUR(150);
    }

    protected function giveMeTheDescription(): string
    {
        return 'Extra cheese';
    }
}
