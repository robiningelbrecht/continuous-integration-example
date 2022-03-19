<?php

namespace App\Tests\Domain\Pizza\OrderCustomPizza;

use App\Domain\Order\MemoryBasedOrderRepository;
use App\Domain\Order\Order;
use App\Domain\Order\OrderId;
use App\Domain\Pizza\BasicPizza;
use App\Domain\Pizza\Crust;
use App\Domain\Pizza\OrderCustomPizza\OrderCustomPizza;
use App\Domain\Pizza\OrderCustomPizza\OrderCustomPizzaCommandHandler;
use App\Domain\Pizza\Size;
use App\Domain\Pizza\Topping\Mushrooms;
use App\Domain\Pizza\Topping\Peppers;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OrderCustomPizzaCommandHandlerTest extends TestCase
{
    private OrderCustomPizzaCommandHandler $orderCustomPizzaCommandHandler;
    private MockObject $orderRepository;

    public function testHandle(): void
    {
        $orderId = OrderId::random();
        $command = new OrderCustomPizza(
            (string) $orderId,
            'small',
            'thin',
            ['mushrooms', 'peppers'],
        );

        $this->orderRepository
            ->expects($this->once())
            ->method('add')
            ->with(Order::create(
                $orderId,
                new Peppers(new Mushrooms(BasicPizza::fromSizeAndCrust(Size::SMALL, Crust::THIN)))
            ));

        $this->orderCustomPizzaCommandHandler->handle($command);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->createMock(MemoryBasedOrderRepository::class);
        $this->orderCustomPizzaCommandHandler = new OrderCustomPizzaCommandHandler(
            $this->orderRepository
        );
    }
}
