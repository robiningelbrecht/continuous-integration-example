<?php

namespace App\Tests\Infrastructure;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class DomainCommandTest extends TestCase
{
    use MatchesSnapshots;

    public function testJsonSerialize(): void
    {
        $command = new TestCommand(
            'value',
            [
                'key' => 'value1',
                'anotherKey' => 'value2',
            ],
        );

        $this->assertMatchesJsonSnapshot(json_encode($command));
    }
}
