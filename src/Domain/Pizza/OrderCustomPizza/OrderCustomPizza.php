<?php

namespace App\Domain\Pizza\OrderCustomPizza;

use App\Domain\Order\OrderId;
use App\Domain\Pizza\Crust;
use App\Domain\Pizza\Size;
use App\Domain\Pizza\Topping\Topping;
use App\Infrastructure\DomainCommand;

class OrderCustomPizza extends DomainCommand
{
    /**
     * @var Topping[]
     */
    protected array $toppings;
    protected OrderId $orderId;
    protected Size $size;
    protected Crust $crust;

    /**
     * @param string[] $toppings
     */
    public function __construct(
        string $orderId,
        string $size,
        string $crust,
        array $toppings = [],
    ) {
        $this->orderId = OrderId::fromString($orderId);
        $this->size = Size::from($size);
        $this->crust = Crust::from($crust);
        $this->toppings = Topping::mapOnStrings($toppings);
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

    /**
     * @return Topping[]
     */
    public function getToppings(): array
    {
        return $this->toppings;
    }
}
