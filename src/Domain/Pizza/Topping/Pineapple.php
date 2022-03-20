<?php

namespace App\Domain\Pizza\Topping;

use Money\Money;

class Pineapple extends BaseTopping
{
    protected function giveMeThePrice(): Money
    {
        return Money::EUR(100);
    }

    protected function giveMeTheDescription(): string
    {
        return 'Pineapple';
    }
}
