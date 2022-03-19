<?php

namespace App\Domain\Pizza\Topping;

use Money\Money;

class Mushrooms extends BaseTopping
{
    protected function giveMeThePrice(): Money
    {
        return Money::EUR(100);
    }

    protected function giveMeTheDescription(): string
    {
        return 'Mushrooms';
    }
}
