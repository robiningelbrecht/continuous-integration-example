<?php

namespace App\Domain\Pizza\Topping;

enum Topping: string
{
    case EXTRA_CHEESE = 'extraCheese';
    case GARLIC = 'garlic';
    case HAM = 'ham';
    case MUSHROOMS = 'mushrooms';
    case PEPPERONI = 'pepperoni';
    case PEPPERS = 'peppers';
    case UNIONS = 'unions';
    public function fqdn(): string
    {
        return match ($this) {
            self::EXTRA_CHEESE => ExtraCheese::class,
            self::GARLIC => Garlic::class,
            self::HAM => Ham::class,
            self::MUSHROOMS => Mushrooms::class,
            self::PEPPERONI => Pepperoni::class,
            self::PEPPERS => Peppers::class,
            self::UNIONS => Unions::class,
        };
    }

    /**
     * @param string[] $strings
     *
     * @return Topping[]
     */
    public static function mapOnStrings(array $strings): array
    {
        return array_map(fn (string $string): Topping => Topping::from($string), $strings);
    }
}
