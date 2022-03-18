<?php

namespace App\Domain\Pizza\Topping;

use Money\Money;

class Pepperoni extends Topping
{
    protected function giveMeThePrice(): Money
    {
        return Money::EUR(100);
    }

    protected function giveMeTheDescription(): array
    {
        return ['Pepperoni'];
    }
}
