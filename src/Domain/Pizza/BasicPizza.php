<?php

namespace App\Domain\Pizza;

use App\Domain\Pizza\Crust\Crust;
use App\Domain\Pizza\Size\Size;
use Money\Money;

class BasicPizza implements Pizza
{
    public function __construct(
        private Size $size,
        private Crust $crust,
    ) {
    }

    public function getPrice(): Money
    {
        return $this->crust->getPrice()->add($this->size->getPrice());
    }

    public function getDescription(): array
    {
        return [...$this->size->getDescription(), ...$this->crust->getDescription(), 'Tomato sauce', 'Cheese'];
    }

    public function jsonSerialize(): mixed
    {
       return [
           'price' => $this->getPrice(),
           'description' => implode(', ', $this->getDescription()),
       ];
    }


}
