<?php

namespace App\Domain\Pizza;

use Money\Money;

interface Pizza extends \JsonSerializable
{
    public function getPrice(): Money;

    /**
     * @return array<mixed>
     */
    public function getToppings(): array;

    /**
     * @return string[]
     */
    public function getDescription(): array;
}
