<?php

namespace App\Domain\Pizza\OrderPepperoniPizza;

use App\Domain\Order\MemoryBasedOrderRepository;
use App\Domain\Order\Order;
use App\Domain\Pizza\PizzaFactory;

class OrderPepperoniPizzaCommandHandler
{
    public function __construct(
        private MemoryBasedOrderRepository $orderRepository,
    ) {
    }

    public function handle(OrderPepperoniPizza $command): void
    {
        $order = Order::create(
            $command->getOrderId(),
            PizzaFactory::pepperoni($command->getSize(), $command->getCrust())
        );

        $this->orderRepository->add($order);
    }
}
