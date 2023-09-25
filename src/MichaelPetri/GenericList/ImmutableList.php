<?php

declare(strict_types=1);

namespace MichaelPetri\GenericList;

/**
 * @template T
 * @psalm-readonly
 */
final class ImmutableList
{
    /** @psalm-param list<T> $items */
    private function __construct(private readonly array $items)
    {
    }

    /**
     * @template TInit
     *
     * @param array<array-key, TInit> $items
     *
     * @psalm-return self<TInit>
     */
    public static function of(mixed ...$items): self
    {
        return new self(
            \array_values(
                $items
            )
        );
    }

    /**
     * @template TOut
     *
     * @psalm-param pure-callable(T): TOut $callback
     *
     * @psalm-return self<TOut>
     */
    public function map(callable $callback): self
    {
        $items = $this->items;

        return new ImmutableList(
            \array_map(
                $callback,
                $items
            )
        );
    }

    /**
     * @psalm-param pure-callable(T): bool $callback
     *
     * @psalm-return self<T>
     */
    public function filter(callable $callback): self
    {
        $items = $this->items;

        return new ImmutableList(
            \array_values(
                \array_filter(
                    $items,
                    $callback
                )
            )
        );
    }

    /**
     * @psalm-param callable(T): void $callback
     *
     * @psalm-return self<T>
     */
    public function each(callable $callback): self
    {
        foreach ($this->items as $item) {
            ($callback)($item);
        }

        return $this;
    }

    /** @psalm-return list<T> */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @psalm-param T $item
     * @psalm-return self<T>
     */
    public function with(mixed $item): self
    {
        return self::of(...[...$this->toArray(), $item]);
    }

    /** @psalm-return self<T> */
    public function unique(): self
    {
        return self::of(...\array_unique($this->items));
    }
}
