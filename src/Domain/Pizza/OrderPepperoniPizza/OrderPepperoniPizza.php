<?php

namespace App\Domain\Pizza\OrderPepperoniPizza;

use App\Domain\Order\OrderId;
use App\Domain\Pizza\Crust;
use App\Domain\Pizza\Size;
use App\Infrastructure\DomainCommand;

class OrderPepperoniPizza extends DomainCommand
{
    protected OrderId $orderId;
    protected Size $size;
    protected Crust $crust;

    public function __construct(
        string $orderId,
        string $size,
        string $crust,
    ) {
        $this->orderId = OrderId::fromString($orderId);
        $this->size = Size::from($size);
        $this->crust = Crust::from($crust);
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getSize(): Size
    {
        return $this->size;
    }

    public function getCrust(): Crust
    {
        return $this->crust;
    }
}
