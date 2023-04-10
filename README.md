# fluent-bcmath

Fluent BcMath is a fluent interface for the PHP BcMath extension.

It helps you to write more readable code, while maintaining the performance of the BcMath extension.

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