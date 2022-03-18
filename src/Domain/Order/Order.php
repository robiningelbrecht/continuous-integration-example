<?php

namespace App\Domain\Order;

use App\Domain\Pizza\Pizza;

class Order implements \JsonSerializable
{
    /**
     * @var Pizza[]
     */
    private array $pizzas;

    private function __construct(
        private OrderId $orderId,
        Pizza $first,
        Pizza ...$others,
    ) {
        $this->pizzas = [$first, ...$others];
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    /**
     * @return Pizza[]
     */
    public function getPizzas(): array
    {
        return $this->pizzas;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'orderId' => (string) $this->getOrderId(),
            'pizzas' => $this->getPizzas(),
        ];
    }

    public static function create(
        OrderId $orderId,
        Pizza $first,
        Pizza ...$others,
    ): self {
        return new self(
            $orderId,
            ...[$first, ...$others],
        );
    }
}
