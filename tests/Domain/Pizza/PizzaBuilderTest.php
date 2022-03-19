<?php

namespace App\Tests\Domain\Pizza;

use App\Domain\Pizza\Crust;
use App\Domain\Pizza\PizzaBuilder;
use App\Domain\Pizza\Size;
use App\Domain\Pizza\Topping\Topping;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class PizzaBuilderTest extends TestCase
{
    use MatchesSnapshots;

    public function testWithoutToppings(): void
    {
        $pizza = PizzaBuilder::fromSizeAndCrust(Size::MEDIUM, Crust::THIN)->build();
        $this->assertMatchesJsonSnapshot(json_encode($pizza));
    }

    public function testWithToppings(): void
    {
        $pizza = PizzaBuilder::fromSizeAndCrust(Size::MEDIUM, Crust::THIN)
            ->withToppings(
                Topping::EXTRA_CHEESE,
                Topping::GARLIC,
                Topping::HAM,
                Topping::MUSHROOMS,
                Topping::PEPPERONI,
                Topping::PEPPERS,
                Topping::UNIONS
            )
            ->build();
        $this->assertMatchesJsonSnapshot(json_encode($pizza));
    }
}
