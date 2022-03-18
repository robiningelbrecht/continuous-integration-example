<?php

namespace App\Domain\Pizza\Crust;

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
