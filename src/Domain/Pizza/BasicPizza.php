<?php

namespace App\Domain\Pizza;

use App\Domain\Pizza\Crust\Crust;
use App\Domain\Pizza\Size\Size;
use Money\Money;

class BasicPizza implements Pizza
{
    public function __construct(
        private Crust $crust,
        private Size $size,
    ) {
    }

    public function getPrice(): Money
    {
        return $this->crust->getPrice()->add($this->size->getPrice());
    }

    public function getDescription(): array
    {
        return [...$this->size->getDescription(), ...$this->crust->getDescription()];
    }
}
