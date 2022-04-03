<?php

namespace App\Domain\Pizza;

class MemoryBasedPizzaRepository
{
    /**
     * @var Pizza[]
     */
    private array $pizzas;

    public function __construct()
    {
        $this->pizzas = [];
    }

    public function add(string $name, Pizza $pizza): void
    {
        if (array_key_exists($name, $this->pizzas)) {
            throw new \RuntimeException('Pizza already exists: '.$name);
        }

        $this->pizzas[$name] = $pizza;
    }

    public function find(string $name): Pizza
    {
        if (!array_key_exists($name, $this->pizzas)) {
            throw new \RuntimeException('Pizza not found: '.$name);
        }

        return $this->pizzas[$name];
    }

    /**
     * @return Pizza[]
     */
    public function findAll(): array
    {
        return $this->pizzas;
    }
}
