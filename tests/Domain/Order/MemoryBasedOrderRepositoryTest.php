<?php

namespace App\Tests\Domain\Order;

use App\Domain\Order\MemoryBasedOrderRepository;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Pizza\Crust;
use App\Domain\Pizza\PizzaFactory;
use App\Domain\Pizza\Size;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class MemoryBasedOrderRepositoryTest extends TestCase
{
    use MatchesSnapshots;

    private MemoryBasedOrderRepository $orderRepository;

    public function testSaveAndFind(): void
    {
        $this->orderRepository->add(Order::create(
            OrderId::fromString('order-test'),
            PizzaFactory::neapolitan(Size::MEDIUM),
            PizzaFactory::pepperoni(Size::LARGE, Crust::THICK)
        ));
        $this->orderRepository->add(Order::create(
            OrderId::fromString('order-test2'),
            PizzaFactory::veggie(Size::MEDIUM),
        ));

        $this->assertMatchesJsonSnapshot(json_encode($this->orderRepository->findAll()));
    }

    public function testItShouldThrowOnDuplicateOrderId(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Order already exists: order-test');

        $this->orderRepository->add(Order::create(
            OrderId::fromString('order-test'),
            PizzaFactory::neapolitan(Size::MEDIUM),
            PizzaFactory::pepperoni(Size::LARGE, Crust::THICK)
        ));
        $this->orderRepository->add(Order::create(
            OrderId::fromString('order-test'),
            PizzaFactory::veggie(Size::MEDIUM),
        ));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = new MemoryBasedOrderRepository();
    }
}
