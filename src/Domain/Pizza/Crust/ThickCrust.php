<?php

namespace App\Domain\Pizza\Crust;

use App\Domain\Pizza\Pizza;
use Money\Money;

class ThickCrust implements Pizza
{
    public function __construct(
        private Pizza $pizza
    ) {
    }

    public function getPrice(): Money
    {
        return $this->pizza->getPrice()->add(Money::EUR(200));
    }

    public function getDescription(): array
    {
        return [...$this->pizza->getDescription(), 'Thick crust'];
    }
}
