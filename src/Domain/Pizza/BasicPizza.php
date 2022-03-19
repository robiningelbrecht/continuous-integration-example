<?php

namespace App\Domain\Pizza;

use Money\Money;

class BasicPizza implements Pizza
{
    private function __construct(
        private Size $size,
        private Crust $crust,
    ) {
    }

    public function getPrice(): Money
    {
        return $this->crust->getPrice()->add($this->size->getPrice());
    }

    public function getToppings(): array
    {
        return [];
    }

    public function getDescription(): array
    {
        return [$this->size->getDescription(), $this->crust->getDescription(), 'Tomato sauce', 'Cheese'];
    }

    public function jsonSerialize(): mixed
    {
        return [
           'price' => $this->getPrice(),
           'toppings' => [],
           'description' => implode(', ', $this->getDescription()),
       ];
    }

    public static function fromSizeAndCrust(Size $size, Crust $crust): self
    {
        return new self($size, $crust);
    }
}
