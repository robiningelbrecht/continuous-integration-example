<?php

namespace App\Domain\Pizza;

use App\Domain\Pizza\Topping\Topping;

class PizzaBuilder
{
    /**
     * @var Topping[]
     */
    private array $toppings;

    private function __construct(
        private Size $size,
        private Crust $crust
    ) {
        $this->toppings = [];
    }

    public static function fromSizeAndCrust(Size $size, Crust $crust): self
    {
        return new self($size, $crust);
    }

    public function build(): Pizza
    {
        if (!$this->toppings) {
            return BasicPizza::fromSizeAndCrust(
                $this->size,
                $this->crust,
            );
        }

        $pizza = BasicPizza::fromSizeAndCrust(
            $this->size,
            $this->crust,
        );

        foreach ($this->toppings as $topping) {
            $fqdn = $topping->fqdn();
            /** @var Pizza $pizza */
            $pizza = new $fqdn($pizza);
        }

        return $pizza;
    }

    public function withToppings(Topping ...$toppings): self
    {
        $this->toppings = $toppings;

        return $this;
    }
}
