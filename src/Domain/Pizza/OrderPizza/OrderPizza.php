<?php

namespace App\Domain\Pizza\OrderPizza;

use App\Domain\Order\OrderId;
use App\Domain\Pizza\Pizza;
use App\Infrastructure\DomainCommand;

class OrderPizza extends DomainCommand
{
    /**
     * @var Pizza[]
     */
    private array $pizzas;

    public function __construct(
        protected OrderId $orderId,
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
}
