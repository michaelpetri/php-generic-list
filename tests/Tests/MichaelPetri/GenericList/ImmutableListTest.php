<?php

declare(strict_types=1);

namespace Tests\MichaelPetri\GenericList;

use MichaelPetri\GenericList\ImmutableList;
use PHPUnit\Framework\TestCase;

use function array_sum;
use function strval;

/** @covers \MichaelPetri\GenericList\ImmutableList */
final class ImmutableListTest extends TestCase
{
    public function testFilter(): void
    {
        self::assertEquals(
            ImmutableList::of(2, 4, 6, 8, 10),
            ImmutableList::of(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
                ->filter(
                    static fn (int $i): bool => 0 === $i % 2
                )
        );
    }

    public function testMap(): void
    {
        self::assertEquals(
            ImmutableList::of(2, 4, 8, 16, 32, 64, 128, 256, 512, 1024),
            ImmutableList::of(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
                ->map(
                    static fn (int $i): int => 2 ** $i
                )
        );
    }

    public function testEach(): void
    {
        $calculator = new class () {
            /** @var list<int> */
            private array $operations = [];
            public function add(int $value): void
            {
                $this->operations[] = $value;
            }

            public function sum(): int
            {
                return array_sum($this->operations);
            }
        };

        ImmutableList::of(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
            ->each(
                $calculator->add(...)
            );

        self::assertEquals(55, $calculator->sum());
    }

    public function testToArray(): void
    {
        self::assertEquals(
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            ImmutableList::of(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)->toArray()
        );
    }

    public function testWith(): void
    {
        /** @psalm-var ImmutableList<positive-int> $list */
        $list = ImmutableList::of(1, 2);

        self::assertEquals(
            ImmutableList::of(1, 2, 3),
            $list->with(3)
        );
    }

    public function testUnique(): void
    {
        self::assertEquals(
            ImmutableList::of(1, 2, 3),
            ImmutableList::of(1, 2, 3, 2, 1)->unique()
        );
    }
}
