# PHP Generic List

[![Type Coverage](https://shepherd.dev/github/michaelpetri/php-generic-list/coverage.svg)](https://shepherd.dev/github/michaelpetri/php-generic-list)
[![Latest Stable Version](https://poser.pugx.org/michaelpetri/php-generic-list/v)](https://packagist.org/packages/michaelpetri/php-generic-list)
[![License](https://poser.pugx.org/michaelpetri/php-generic-list/license)](https://packagist.org/packages/michaelpetri/php-generic-list)

## Installation:
```
composer require michaelpetri/php-generic-list 
```

## Usage:

```php
ImmutableList::of([1, 2, 3, 4, 5])
    ->filter(
        static fn(int $i): bool => 0 === $i % 2
    )
    ->map(
        static fn(int $i): int => 2 ** $i
    )
    ->each(
        static function (int $i): void { sprintf("\d\n", $i) }
    )

// Output:
// 4 
// 16
```

## Available methods:

* `map`
* `filter`
* `each`
* `toArray`