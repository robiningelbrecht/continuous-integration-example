<?php

namespace App\Tests\Domain\Pizza\OrderPizza;

use App\Domain\Order\FileBasedOrderRepository;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Pizza\OrderPizza\OrderPizza;
use App\Domain\Pizza\OrderPizza\OrderPizzaCommandHandler;
use App\Domain\Pizza\PizzaFactory;
use App\Domain\Pizza\Size\Large;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OrderPizzaCommandHandlerTest extends TestCase
{
    private OrderPizzaCommandHandler $orderPizzaCommandHandler;
    private MockObject $orderRepository;

    public function testHandle(): void
    {
        $orderId = OrderId::random();
        $pizza = PizzaFactory::veggie(new Large());
        $command = new OrderPizza(
            $orderId,
            $pizza,
        );

        $this->orderRepository
            ->expects($this->once())
            ->method('add')
            ->with(Order::create(
                $orderId,
                $pizza
            ));

        $this->orderPizzaCommandHandler->handle($command);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->createMock(FileBasedOrderRepository::class);
        $this->orderPizzaCommandHandler = new OrderPizzaCommandHandler(
            $this->orderRepository
        );
    }
}