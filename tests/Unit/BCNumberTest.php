<?php

use Illegal\FluentBCMath\BCNumber;

dataset('numbers', [
    ['number' => rand(1, 1000), 'scale' => rand(0, 20)],
    ['number' => rand(1, 1000), 'scale' => rand(0, 20)],
    ['number' => rand(1, 1000), 'scale' => rand(0, 20)],
    ['number' => rand(1, 1000), 'scale' => rand(0, 20)],
    ['number' => rand(1, 1000), 'scale' => rand(0, 20)],
    ['number' => rand(1, 1000) / rand(1, 1000), 'scale' => rand(1, 20)],
    ['number' => rand(1, 1000) / rand(1, 1000), 'scale' => rand(1, 20)],
    ['number' => rand(1, 1000) / rand(1, 1000), 'scale' => rand(1, 20)],
    ['number' => rand(1, 1000) / rand(1, 1000), 'scale' => rand(1, 20)],
    ['number' => rand(1, 1000) / rand(1, 1000), 'scale' => rand(1, 20)],
]);

test('helper function fnum() creates a new BCNumber instance', function ($number, $scale) {
    expect(fnum($number, $scale))->toBeInstanceOf(BCNumber::class);
})->with('numbers');

it('returns the correct value', function ($number, $scale) {
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->val())->toBe(bcmul($number, '1', $scale));
})->with('numbers');

it('converts correctly to string', function ($number) {
    $bcNumber = new BCNumber($number, 20);
    expect($bcNumber->__toString())->toBeString()->toStartWith($number);
})->with('numbers');

it('converts correctly to float', function ($number, $scale) {
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->toFloat())->toBeFloat();
})->with('numbers');

it('converts correctly to int', function ($number, $scale) {
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->toInt())->toBeInt();
})->with('numbers');

it('correctly adds numbers', function ($number, $scale) {
    $operator = rand(1, 1000);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->add($operator)->val())->toBe(bcadd($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->addIf($operator, fn() => true)->val())->toBe(bcadd($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->addIf($operator, fn() => false)->val())->toBe($bcNumber->val())
        ->and($bcNumber->add($bcNumber)->val())->toBe(bcadd($bcNumber->val(), $bcNumber->val(), $scale));
})->with('numbers');

it('correctly subtracts numbers', function ($number, $scale) {
    $operator = rand(1, 1000);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->sub($operator)->val())->toBe(bcsub($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->subIf($operator, fn() => true)->val())->toBe(bcsub($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->subIf($operator, fn() => false)->val())->toBe($bcNumber->val())
        ->and($bcNumber->sub($bcNumber)->val())->toBe(bcsub($bcNumber->val(), $bcNumber->val(), $scale));
})->with('numbers');

it('correctly multiplies numbers', function ($number, $scale) {
    $operator = rand(1, 1000);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->mul($operator)->val())->toBe(bcmul($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->mulIf($operator, fn() => true)->val())->toBe(bcmul($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->mulIf($operator, fn() => false)->val())->toBe($bcNumber->val())
        ->and($bcNumber->mul($bcNumber)->val())->toBe(bcmul($bcNumber->val(), $bcNumber->val(), $scale));
})->with('numbers');

it('correctly divides numbers', function ($number, $scale) {
    $operator = rand(1, 1000);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->div($operator)->val())->toBe(bcdiv($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->divIf($operator, fn() => true)->val())->toBe(bcdiv($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->divIf($operator, fn() => false)->val())->toBe($bcNumber->val())
        ->and($bcNumber->div($bcNumber)->val())->toBe(bcdiv($bcNumber->val(), $bcNumber->val(), $scale));
})->with('numbers');

it('correctly calculates the modulus', function ($number, $scale) {
    $operator = rand(1, 1000);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->mod($operator)->val())->toBe(bcmod($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->modIf($operator, fn() => true)->val())->toBe(bcmod($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->modIf($operator, fn() => false)->val())->toBe($bcNumber->val())
        ->and($bcNumber->mod($bcNumber)->val())->toBe(bcmod($bcNumber->val(), $bcNumber->val(), $scale));
})->with('numbers');

it('correctly calculates the power', function ($number) {
    $scale    = 0;
    $operator = rand(1, 1000);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->pow($operator)->val())->toBe(bcpow($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->powIf($operator, fn() => true)->val())->toBe(bcpow($bcNumber->val(), $operator, $scale))
        ->and($bcNumber->powIf($operator, fn() => false)->val())->toBe($bcNumber->val())
        ->and($bcNumber->pow($bcNumber->val())->val())->toBe(bcpow($bcNumber->val(), $bcNumber->val(), $scale));
})->with('numbers');

it('correctly calculates the square root', function ($number, $scale) {
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->sqrt()->val())->toBe(bcsqrt($bcNumber->val(), $scale))
        ->and($bcNumber->sqrtIf(fn() => true)->val())->toBe(bcsqrt($bcNumber->val(), $scale))
        ->and($bcNumber->sqrtIf(fn() => false)->val())->toBe($bcNumber->val());
})->with('numbers');

it('correctly scales the number', function ($number, $scale) {
    $newScale = rand(1, 1000);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->scale($newScale)->val())->toBe(bcmul($bcNumber->val(), 1, $newScale));
})->with('numbers');

it('correctly checks if two numbers are equal', function ($number, $scale) {
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->equals(bcmul($number, 1, $scale)))->toBeTrue();
})->with('numbers');

it('correctly checks if a number is greater than another', function ($number, $scale) {
    $more = bcadd($number, 100, $scale);
    $less = bcsub($number, 100, $scale);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->greaterThan($more))->toBeFalse()
        ->and($bcNumber->greaterThan($less))->toBeTrue()
        ->and($bcNumber->greaterThan($number))->toBeFalse()
        ->and($bcNumber->greaterThan($bcNumber))->toBeFalse();
})->with('numbers');

it('correctly checks if a number is greater than or equal to another', function ($number, $scale) {
    $more = bcadd($number, 100, $scale);
    $less = bcsub($number, 100, $scale);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->greaterThanOrEqual($more))->toBeFalse()
        ->and($bcNumber->greaterThanOrEqual($less))->toBeTrue()
        ->and($bcNumber->greaterThanOrEqual($number))->toBeTrue()
        ->and($bcNumber->greaterThanOrEqual($bcNumber))->toBeTrue();
})->with('numbers');

it('correctly checks if a number is less than another', function ($number, $scale) {
    $more = bcadd($number, 100, $scale);
    $less = bcsub($number, 100, $scale);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->lessThan($more))->toBeTrue()
        ->and($bcNumber->lessThan($less))->toBeFalse()
        ->and($bcNumber->lessThan($number))->toBeFalse()
        ->and($bcNumber->lessThan($bcNumber))->toBeFalse();
})->with('numbers');

it('correctly checks if a number is less than or equal to another', function ($number, $scale) {
    $more = bcadd($number, 100, $scale);
    $less = bcsub($number, 100, $scale);
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->lessThanOrEqual($more))->toBeTrue()
        ->and($bcNumber->lessThanOrEqual($less))->toBeFalse()
        ->and($bcNumber->lessThanOrEqual($number))->toBeTrue()
        ->and($bcNumber->lessThanOrEqual($bcNumber))->toBeTrue();
})->with('numbers');

it('correctly checks if a number is zero', function ($number, $scale) {
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->isZero())->toBeFalse()
        ->and($bcNumber->sub($bcNumber)->isZero())->toBeTrue();
})->with('numbers');

it('correctly checks if a number is positive', function ($number, $scale) {
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->isPositive())->toBeTrue()
        ->and($bcNumber->sub($number * 2)->isPositive())->toBeFalse();
})->with('numbers');

it('correctly checks if a number is negative', function ($number, $scale) {
    $bcNumber = new BCNumber($number, $scale);
    expect($bcNumber->isNegative())->toBeFalse()
        ->and($bcNumber->sub($number * 2)->isNegative())->toBeTrue();
})->with('numbers');

it('correctly checks if a number is even or not odd', function ($number) {
    $bcNumber = new BCNumber($number, 0);
    expect($bcNumber->isEven())->toBeTrue()
        ->and($bcNumber->isOdd())->toBeFalse();
})->with([2, 4, 6, 8]);

it('correctly checks if a number is odd or not even', function ($number) {
    $bcNumber = new BCNumber($number, 0);
    expect($bcNumber->isOdd())->toBeTrue()
        ->and($bcNumber->isEven())->toBeFalse();
})->with([1, 3, 5, 7]);

it('correctly returns the absolute value of a number', function ($number) {
    $bcNumber = new BCNumber($number, 0);
    expect($bcNumber->abs()->toInt())->toBe(abs($number));
})->with([-2, -4, 3, 6]);

it('correctly returns the negative value of a number', function ($number) {
    $bcNumber = new BCNumber($number, 0);
    expect($bcNumber->negate()->toInt())->toBe(-$number);
})->with([-2, -4, 3, 6]);

it('correctly returns the minimum value between two numbers', function ($number) {
    $comparison = rand(1, 10);
    $bcNumber = new BCNumber($number, 0);
    expect($bcNumber->min($comparison)->toFloat())->toBe((float)min($number, $comparison));
})->with([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

it('correctly returns the maximum value between two numbers', function ($number) {
    $comparison = rand(1, 10);
    $bcNumber = new BCNumber($number, 0);
    expect($bcNumber->max($comparison)->toFloat())->toBe((float)max($number, $comparison));
})->with([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

it('correctly clamps a number between two values', function ($number) {
    $min = rand(1, 10);
    $max = rand(11, 15);
    $bcNumber = new BCNumber($number, 0);
    expect($bcNumber->clamp($min, $max)->toFloat())->toBe((float)min(max($number, $min), $max));
})->with([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);