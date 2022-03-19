<?php

namespace App\Tests\Domain\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Pizza\Crust;
use App\Domain\Pizza\PizzaFactory;
use App\Domain\Pizza\Size;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class OrderTest extends TestCase
{
    use MatchesSnapshots;

    public function testCreate(): void
    {
        $order = Order::create(
            OrderId::fromString('order-test'),
            PizzaFactory::neapolitan(Size::MEDIUM),
            PizzaFactory::pepperoni(Size::LARGE, Crust::THICK)
        );
        $this->assertMatchesJsonSnapshot(json_encode($order));
    }
}
