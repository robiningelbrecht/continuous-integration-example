<?php

namespace App\Tests\Controller;

use App\Controller\PizzaDetailsRequestHandler;
use App\Domain\Pizza\Crust;
use App\Domain\Pizza\MemoryBasedPizzaRepository;
use App\Domain\Pizza\PizzaBuilder;
use App\Domain\Pizza\Size;
use App\Domain\Pizza\Topping\Topping;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class PizzaDetailsRequestHandlerTest extends TestCase
{
    use MatchesSnapshots;

    private PizzaDetailsRequestHandler $pizzaDetailsRequestHandler;
    private MockObject $pizzaRepository;

    public function testHandle(): void
    {
        $pizzaName = 'bestPizzaInTheWorld';
        $this->pizzaRepository
            ->expects($this->once())
            ->method('find')
            ->with($pizzaName)
            ->willReturn(
                PizzaBuilder::fromSizeAndCrust(Size::LARGE, Crust::THICK)
                ->withToppings(Topping::GARLIC, Topping::MUSHROOMS, Topping::UNIONS)
                ->build()
            );

        $this->assertMatchesJsonSnapshot($this->pizzaDetailsRequestHandler->handle($pizzaName)->getContent());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->pizzaRepository = $this->createMock(MemoryBasedPizzaRepository::class);
        $this->pizzaDetailsRequestHandler = new PizzaDetailsRequestHandler($this->pizzaRepository);
    }
}
