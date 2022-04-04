<?php

namespace App\Tests\Controller;

use App\Controller\MenuRequestHandler;
use App\Domain\Pizza\Crust;
use App\Domain\Pizza\MemoryBasedPizzaRepository;
use App\Domain\Pizza\PizzaFactory;
use App\Domain\Pizza\Size;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class MenuRequestHandlerTest extends TestCase
{
    use MatchesSnapshots;

    private MenuRequestHandler $menuRequestHandler;
    private MockObject $pizzaRepository;

    public function testHandle(): void
    {
        $this->pizzaRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([
                PizzaFactory::veggie(Size::MEDIUM),
                PizzaFactory::neapolitan(Size::MEDIUM),
                PizzaFactory::pepperoni(Size::MEDIUM, Crust::THIN),
            ]);

        $this->assertMatchesJsonSnapshot($this->menuRequestHandler->handle()->getContent());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->pizzaRepository = $this->createMock(MemoryBasedPizzaRepository::class);
        $this->menuRequestHandler = new MenuRequestHandler($this->pizzaRepository);
    }
}
