<?php

namespace App\Domain\Pizza;

use App\Domain\Pizza\Topping\Topping;

class PizzaFactory
{
    public static function neapolitan(Size $size): Pizza
    {
        return PizzaBuilder::fromSizeAndCrust($size, Crust::THIN)
            ->withToppings(
                Topping::EXTRA_CHEESE,
                Topping::GARLIC,
                Topping::MUSHROOMS,
                Topping::HAM,
                Topping::PEPPERS
            )
            ->build();
    }

    public static function pepperoni(Size $size, Crust $crust): Pizza
    {
        return PizzaBuilder::fromSizeAndCrust($size, $crust)
            ->withToppings(
                Topping::EXTRA_CHEESE,
                Topping::PEPPERONI,
            )
            ->build();
    }

    public static function veggie(Size $size): Pizza
    {
        return PizzaBuilder::fromSizeAndCrust($size, Crust::THIN)
            ->withToppings(
                Topping::EXTRA_CHEESE,
                Topping::UNIONS,
                Topping::EXTRA_CHEESE,
                Topping::MUSHROOMS,
            )
            ->build();
    }
}
