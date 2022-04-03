<?php

namespace App\Tests\Domain\Pizza;

use App\Domain\Pizza\Crust;
use App\Domain\Pizza\MemoryBasedPizzaRepository;
use App\Domain\Pizza\PizzaFactory;
use App\Domain\Pizza\Size;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class MemoryBasedPizzaRepositoryTest extends TestCase
{
    use MatchesSnapshots;

    private MemoryBasedPizzaRepository $pizzaRepository;

    public function testSaveAndFindAll(): void
    {
        $this->pizzaRepository->add('pepperoni', PizzaFactory::pepperoni(Size::MEDIUM, Crust::THIN));
        $this->pizzaRepository->add('veggie', PizzaFactory::veggie(Size::MEDIUM));
        $this->pizzaRepository->add('neapolitan', PizzaFactory::neapolitan(Size::MEDIUM));

        $this->assertMatchesJsonSnapshot(json_encode($this->pizzaRepository->findAll()));
    }

    public function testItShouldThrowOnDuplicatePizzaName(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Pizza already exists: pepperoni');

        $this->pizzaRepository->add('pepperoni', PizzaFactory::pepperoni(Size::MEDIUM, Crust::THIN));
        $this->pizzaRepository->add('pepperoni', PizzaFactory::pepperoni(Size::MEDIUM, Crust::THIN));
    }

    public function testSaveAndFindOne(): void
    {
        $this->pizzaRepository->add('pepperoni', PizzaFactory::pepperoni(Size::MEDIUM, Crust::THIN));
        $this->pizzaRepository->add('veggie', PizzaFactory::veggie(Size::MEDIUM));

        $this->assertMatchesJsonSnapshot(json_encode($this->pizzaRepository->find('veggie')));
    }

    public function testItShouldThrowOnInvalidPizza(): void
    {
        $this->pizzaRepository->add('pepperoni', PizzaFactory::pepperoni(Size::MEDIUM, Crust::THIN));
        $this->pizzaRepository->add('veggie', PizzaFactory::veggie(Size::MEDIUM));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Pizza not found: test');

        $this->pizzaRepository->find('test');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->pizzaRepository = new MemoryBasedPizzaRepository();
    }
}
