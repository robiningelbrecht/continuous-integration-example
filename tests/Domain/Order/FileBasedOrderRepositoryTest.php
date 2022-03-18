<?php

namespace App\Tests\Domain\Order;

use App\Domain\Order\FileBasedOrderRepository;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Pizza\Crust\ThickCrust;
use App\Domain\Pizza\PizzaFactory;
use App\Domain\Pizza\Size\Large;
use App\Domain\Pizza\Size\Medium;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class FileBasedOrderRepositoryTest extends TestCase
{
    use MatchesSnapshots;

    private FileBasedOrderRepository $orderRepository;

    public function testSaveAndFind(): void
    {
        $this->orderRepository->truncate();

        $this->orderRepository->add(Order::create(
            OrderId::fromString('order-test'),
            PizzaFactory::neapolitan(new Medium()),
            PizzaFactory::pepperoni(new Large(), new ThickCrust())
        ));
        $this->orderRepository->add(Order::create(
            OrderId::fromString('order-test2'),
            PizzaFactory::veggie(new Medium()),
        ));

        $this->assertMatchesJsonSnapshot(json_decode(file_get_contents(FileBasedOrderRepository::ORDERS_FILE) ?: '[]', true));
    }

    public function itShouldThrowOnDuplicateOrderId(): void
    {
        $this->orderRepository->truncate();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Order already exists: order-test');

        $this->orderRepository->add(Order::create(
            OrderId::fromString('order-test'),
            PizzaFactory::neapolitan(new Medium()),
            PizzaFactory::pepperoni(new Large(), new ThickCrust())
        ));
        $this->orderRepository->add(Order::create(
            OrderId::fromString('order-test'),
            PizzaFactory::veggie(new Medium()),
        ));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = new FileBasedOrderRepository();
    }
}
