<?php

namespace App\Tests\Domain\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Pizza\Crust\ThickCrust;
use App\Domain\Pizza\PizzaFactory;
use App\Domain\Pizza\Size\Large;
use App\Domain\Pizza\Size\Medium;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class OrderTest extends TestCase
{
    use MatchesSnapshots;

    public function testCreate(): void
    {
        $order = Order::create(
            OrderId::fromString('order-test'),
            PizzaFactory::neapolitan(new Medium()),
            PizzaFactory::pepperoni(new Large(), new ThickCrust())
        );
        $this->assertMatchesJsonSnapshot(json_encode($order));
    }
}
