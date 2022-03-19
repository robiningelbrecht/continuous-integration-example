<?php

namespace App\Domain\Pizza\OrderCustomPizza;

use App\Domain\Order\MemoryBasedOrderRepository;
use App\Domain\Order\Order;
use App\Domain\Pizza\PizzaBuilder;

class OrderCustomPizzaCommandHandler
{
    public function __construct(
        private MemoryBasedOrderRepository $orderRepository,
    ) {
    }

    public function handle(OrderCustomPizza $command): void
    {
        $order = Order::create(
            $command->getOrderId(),
            PizzaBuilder::fromSizeAndCrust($command->getSize(), $command->getCrust())
                ->withToppings(...$command->getToppings())
                ->build()
        );

        $this->orderRepository->add($order);
    }
}
