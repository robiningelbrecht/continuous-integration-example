<?php

namespace App\Domain\Order;

class FileBasedOrderRepository
{
    public const ORDERS_FILE = __DIR__.'/orders.json';

    public function add(Order $order): void
    {
        /** @var array<mixed> $orders */
        $orders = json_decode(file_get_contents(self::ORDERS_FILE) ?: '[]', true);

        if (array_key_exists((string) $order->getOrderId(), $orders)) {
            throw new \RuntimeException('Order already exists: '.$order->getOrderId());
        }

        $orders[(string) $order->getOrderId()] = $order;

        file_put_contents(self::ORDERS_FILE, json_encode($orders) ?: '');
    }

    public function truncate(): void
    {
        file_put_contents(self::ORDERS_FILE, '[]');
    }
}
