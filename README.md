<p align="center">
  <img src="assets/logo-transparent.png" alt="Fluent BCMath logo" width="130">
</p>

<h1 align="center">Fluent BCMath</h1>

<p align="center">
  <em>Precise arithmetic. Fluent code.</em>
</p>

<p align="center">
  <a href="https://packagist.org/packages/illegal/fluent-bcmath"><img src="https://img.shields.io/packagist/v/illegal/fluent-bcmath?style=flat-square&amp;logo=composer&amp;logoColor=white&amp;color=007C98" alt="Latest stable version"></a>
  <a href="https://packagist.org/packages/illegal/fluent-bcmath"><img src="https://img.shields.io/packagist/dt/illegal/fluent-bcmath?style=flat-square&amp;logo=composer&amp;logoColor=white&amp;color=007C98" alt="Total downloads"></a>
  <a href="composer.json"><img src="https://img.shields.io/badge/PHP-%3E%3D8.1-007C98?style=flat-square&amp;logo=php&amp;logoColor=white&amp;color=007C98" alt="PHP 8.1 or newer"></a>
  <a href="LICENSE"><img src="https://img.shields.io/github/license/illegalstudio/fluent-bcmath?style=flat-square&amp;color=007C98" alt="License: MIT"></a>
  <a href="https://github.com/illegalstudio/fluent-bcmath/stargazers"><img src="https://img.shields.io/github/stars/illegalstudio/fluent-bcmath?style=flat-square&amp;logo=github&amp;logoColor=white&amp;label=stars&amp;color=007C98" alt="GitHub stars"></a>
</p>

<p align="center">
  <strong>Arbitrary precision &middot; Chainable operations &middot; Immutable numbers &middot; PHP 8.1+</strong>
</p>

<p align="center">
  Fluent BCMath brings an expressive, fluent interface to PHP's BCMath extension.
  Chain arithmetic operations and compare numbers while keeping control over decimal precision.
</p>

<p align="center">
  <a href="https://fluent-bcmath.illegal.studio/"><strong>Official Website</strong></a>
</p>

---

## Installation

Install the package via composer:

```bash
composer require "illegal/fluent-bcmath"
```

## Usage

You have two options to use the fluent interface.

In both cases, there are two arguments: the number and the scale.
The number can be:
- a string
- an integer
- a float
- another `BCNumber` instance

The scale is an integer, which represents the number of digits after the decimal point.

All methods return a new `BCNumber` instance, so you can chain them.

For example:

```php
use Illegal\FluentBCMath\BCNumber;
$num = new BCNumber('1.23', 2);

$num->add(2)->sub(2)->mul(2)->div(2)->mod(3)->pow(2)->sqrt();
```

### 1. Use the `BCNumber` class

```php
use Illegal\FluentBCMath\BCNumber;

$num = new BCNumber('1.23', 2); // 1st argument is the number, 2nd argument is the scale
```

### 2. Use the `fnum()` helper function

```php
$num = fnum('1.23', 2); // 1st argument is the number, 2nd argument is the scale
```

## Available methods

```php
$num = fnum(10, 2);

$num->add(2); // 12.00
$num->sub(2); // 8.00
$num->mul(2); // 20.00
$num->div(2); // 5.00
$num->mod(3); // 1.00
$num->pow(2); // 100.00
$num->sqrt(); // 3.16

$num->equals(10); // true
$num->greaterThan(5); // true
$num->greaterThanOrEqual(10); // true
$num->lessThan(15); // true
$num->lessThanOrEqual(10); // true
$num->isZero(); // false
$num->isPositive(); // true
$num->isNegative(); // false
$num->isEven(); // true
$num->isOdd(); // false
$num->abs(); // 10.00
$num->negate(); // -10.00
$num->min(5); // 5.00
$num->max(15); // 15.00
$num->clamp(5, 15); // 10.00
```

## If methods

Each operation has an `if` method, which returns the result of the operation, if the condition is true.

```php
$num = fnum(10, 2);

$num->addIf(2, false); // 10.00
$num->subIf(2, false); // 10.00
$num->mulIf(2, false); // 10.00
$num->divIf(2, false); // 10.00
$num->modIf(3, false); // 10.00
$num->powIf(2, false); // 10.00
$num->sqrtIf(false); // 10.00
```

# Testing

```bash
./vendor/bin/pest
```

# License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
