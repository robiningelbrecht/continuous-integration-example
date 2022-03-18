<?php

namespace App\Domain\Pizza;

use App\Domain\Pizza\Crust\Crust;
use App\Domain\Pizza\Crust\ThinCrust;
use App\Domain\Pizza\Size\Size;
use App\Domain\Pizza\Topping\ExtraCheese;
use App\Domain\Pizza\Topping\Garlic;
use App\Domain\Pizza\Topping\Ham;
use App\Domain\Pizza\Topping\Mushrooms;
use App\Domain\Pizza\Topping\Pepperoni;
use App\Domain\Pizza\Topping\Peppers;
use App\Domain\Pizza\Topping\Unions;

class PizzaFactory
{
    public static function neapolitan(Size $size): Pizza
    {
        return new Peppers(new Ham(new Mushrooms(
            new Garlic(new ExtraCheese(
                new BasicPizza($size, new ThinCrust())
            ))
        )));
    }

    public static function pepperoni(Size $size, Crust $crust): Pizza
    {
        return new Pepperoni(new ExtraCheese(
            new BasicPizza($size, $crust)
        ));
    }

    public static function veggie(Size $size): Pizza
    {
        return new Mushrooms(new ExtraCheese(new Unions(
            new ExtraCheese(
                new BasicPizza($size, new ThinCrust())
            )
        )));
    }
}
