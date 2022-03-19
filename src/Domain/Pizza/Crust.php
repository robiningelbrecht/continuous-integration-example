<?php

namespace App\Domain\Pizza;

use Money\Money;

enum Crust: string
{
    case THIN = 'thin';
    case THICK = 'thick';
    public function getPrice(): Money
    {
        return match ($this) {
            self::THIN => Money::EUR(150),
            self::THICK => Money::EUR(200),
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::THIN => 'Thin crust',
            self::THICK => 'Thick crust',
        };
    }
}
