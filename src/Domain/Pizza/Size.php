<?php

namespace App\Domain\Pizza;

use Money\Money;

enum Size: string
{
    case SMALL = 'small';
    case MEDIUM = 'medium';
    case LARGE = 'large';
    public function getPrice(): Money
    {
        return match ($this) {
            self::SMALL => Money::EUR(600),
            self::MEDIUM => Money::EUR(850),
            self::LARGE => Money::EUR(1000),
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::SMALL => 'Small pizza',
            self::MEDIUM => 'Medium pizza',
            self::LARGE => 'Large pizza',
        };
    }
}
