<?php

namespace App\Domain\Pizza\Topping;

use App\Domain\Pizza\Pizza;
use Money\Money;

abstract class Topping implements Pizza
{
    public function __construct(
        private Pizza $pizza
    ) {
    }

    public function getPrice(): Money
    {
        return $this->pizza->getPrice()->add($this->giveMeThePrice());
    }

    public function getDescription(): array
    {
        return [...$this->pizza->getDescription(), ...$this->giveMeTheDescription()];
    }

    public function jsonSerialize(): mixed
    {
        return [
            'price' => $this->getPrice(),
            'description' => implode(', ', $this->getDescription()),
        ];
    }


    abstract protected function giveMeThePrice(): Money;

    /**
     * @return string[]
     */
    abstract protected function giveMeTheDescription(): array;
}
