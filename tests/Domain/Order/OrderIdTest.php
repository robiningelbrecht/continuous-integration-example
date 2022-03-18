<?php

namespace App\Tests\Domain\Order;

use App\Domain\Order\OrderId;
use PHPUnit\Framework\TestCase;

class OrderIdTest extends TestCase
{
    public function testGenerate(): void
    {
        $orderId = OrderId::random();
        $this->assertEquals((string) $orderId, $orderId);

        $orderId = OrderId::fromString('order-test');
        $this->assertEquals('order-test', $orderId);
    }

    public function testItShouldThrowWhenEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('App\Domain\Order\OrderId cannot be empty');

        OrderId::fromString('');
    }

    public function testItShouldThrowWhenInvalidPrefix(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Identifier does not start with prefix "order-", got: prefix-test');

        OrderId::fromString('prefix-test');
    }
}
