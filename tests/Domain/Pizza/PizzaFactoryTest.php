<?php

namespace App\Tests\Domain\Pizza;

use App\Domain\Pizza\Crust\ThinCrust;
use App\Domain\Pizza\PizzaFactory;
use App\Domain\Pizza\Size\Large;
use App\Domain\Pizza\Size\Medium;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class PizzaFactoryTest extends TestCase
{
    use MatchesSnapshots;

    public function testFactory(): void{
        $this->assertMatchesJsonSnapshot(json_encode(PizzaFactory::neapolitan(new Large())));
        $this->assertMatchesJsonSnapshot(json_encode(PizzaFactory::pepperoni(new Medium(), new ThinCrust())));
        $this->assertMatchesJsonSnapshot(json_encode(PizzaFactory::veggie(new Medium())));
    }
}