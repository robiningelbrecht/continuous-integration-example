<?php

namespace App\Domain\Order;

class MemoryBasedOrderRepository
{
    /**
     * @var Order[]
     */
    private array $orders;

    public function __construct()
    {
        $this->orders = [];
    }

    public function add(Order $order): void
    {
        if (array_key_exists((string) $order->getOrderId(), $this->orders)) {
            throw new \RuntimeException('Order already exists: '.$order->getOrderId());
        }

        $this->orders[(string) $order->getOrderId()] = $order;
    }

    /**
     * @return Order[]
     */
    public function findAll(): array
    {
        return $this->orders;
    }
}
