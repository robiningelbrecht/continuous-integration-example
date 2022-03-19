<?php

namespace App\Tests\Domain\Pizza\OrderPepperoniPizza;

use App\Domain\Order\MemoryBasedOrderRepository;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Pizza\OrderPepperoniPizza\OrderPepperoniPizza;
use App\Domain\Pizza\OrderPepperoniPizza\OrderPepperoniPizzaCommandHandler;
use App\Domain\Pizza\PizzaFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OrderPepperoniPizzaCommandHandlerTest extends TestCase
{
    private OrderPepperoniPizzaCommandHandler $orderPepperoniPizzaCommandHandler;
    private MockObject $orderRepository;

    public function testHandle(): void
    {
        $orderId = OrderId::random();
        $command = new OrderPepperoniPizza(
            (string) $orderId,
            'small',
            'thin'
        );

        $this->orderRepository
            ->expects($this->once())
            ->method('add')
            ->with(Order::create(
                $orderId,
                PizzaFactory::pepperoni($command->getSize(), $command->getCrust())
            ));

        $this->orderPepperoniPizzaCommandHandler->handle($command);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->createMock(MemoryBasedOrderRepository::class);
        $this->orderPepperoniPizzaCommandHandler = new OrderPepperoniPizzaCommandHandler(
            $this->orderRepository
        );
    }
}
