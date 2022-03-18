<?php

namespace App\Domain\Pizza\OrderPizza;

use App\Domain\Order\FileBasedOrderRepository;
use App\Domain\Order\Order;

class OrderPizzaCommandHandler
{
    public function __construct(
        private FileBasedOrderRepository $orderRepository,
    ) {
    }

    public function handle(OrderPizza $command): void
    {
        $order = Order::create(
            $command->getOrderId(),
            ...$command->getPizzas()
        );

        $this->orderRepository->add($order);
    }
}
