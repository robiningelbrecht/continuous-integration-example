<?php

namespace App\Domain\Pizza\Topping;

use Money\Money;

class Shrimps extends BaseTopping
{
    protected function giveMeThePrice(): Money
    {
        return Money::EUR(200);
    }

    protected function giveMeTheDescription(): string
    {
        return 'Shrimps';
    }
}
