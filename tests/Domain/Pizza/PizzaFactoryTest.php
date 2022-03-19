<?php

namespace App\Tests\Domain\Pizza;

use App\Domain\Pizza\Crust;
use App\Domain\Pizza\PizzaFactory;
use App\Domain\Pizza\Size;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class PizzaFactoryTest extends TestCase
{
    use MatchesSnapshots;

    public function testFactory(): void
    {
        $this->assertMatchesJsonSnapshot(json_encode(PizzaFactory::neapolitan(Size::LARGE)));
        $this->assertMatchesJsonSnapshot(json_encode(PizzaFactory::pepperoni(Size::MEDIUM, Crust::THIN)));
        $this->assertMatchesJsonSnapshot(json_encode(PizzaFactory::veggie(Size::MEDIUM)));
    }
}
