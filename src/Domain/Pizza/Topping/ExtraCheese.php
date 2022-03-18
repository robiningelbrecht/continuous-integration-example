<?php

namespace App\Domain\Pizza\Topping;

use Money\Money;

class ExtraCheese extends Topping
{
    protected function giveMeThePrice(): Money
    {
        return Money::EUR(150);
    }

    protected function giveMeTheDescription(): array
    {
        return ['Extra cheese'];
    }
}
