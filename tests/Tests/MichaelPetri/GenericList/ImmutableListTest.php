<?php

declare(strict_types=1);

namespace Tests\MichaelPetri\GenericList;

use MichaelPetri\GenericList\ImmutableList;
use PHPUnit\Framework\TestCase;

/** @covers \MichaelPetri\GenericList\ImmutableList */
final class ImmutableListTest extends TestCase
{
    public function testFilter(): void
    {
        self::assertEquals(
            ImmutableList::of([2, 4, 6, 8, 10]),
            ImmutableList::of([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
                ->filter(
                    static fn (int $i): bool => 0 === $i % 2
                )
        );
    }

    public function testMap(): void
    {
        self::assertEquals(
            ImmutableList::of([2, 4, 8, 16, 32, 64, 128, 256, 512, 1024]),
            ImmutableList::of([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
                ->map(
                    static fn (int $i): int => 2 ** $i
                )
        );
    }

    public function testEach(): void
    {
        $sum = 0;

        ImmutableList::of([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
            ->each(
                static function (int $i) use (&$sum): void {
                    $sum += $i;
                }
            );

        self::assertEquals(45, $sum);
    }

    public function testToArray(): void
    {
        self::assertEquals(
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            ImmutableList::of([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->toArray()
        );
    }
}
