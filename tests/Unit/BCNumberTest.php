<?php

use Illegal\FluentBCMath\BCNumber;

test('helper function fnum() creates a new BCNumber instance', function () {
    expect(fnum(0.01))->toBeInstanceOf(BCNumber::class);
});

it('returns the correct value', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->val())->toBe("0.01");
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('converts correctly to string', function($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->__toString())->toBe("0.01");
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('converts correctly to float', function($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->toFloat())->toBe(0.01);
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('converts correctly to int', function($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->toInt())->toBe(0);
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly adds numbers', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->add(0.01)->val())->toBe("0.02")
        ->and($bcNumber->addIf(0.01, fn() => true)->val())->toBe("0.02")
        ->and($bcNumber->add($bcNumber)->val())->toBe("0.02");
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly subtracts numbers', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->sub(0.01)->val())->toBe("0.01")
        ->and($bcNumber->subIf(0.01, fn() => true)->val())->toBe("0.01")
        ->and($bcNumber->sub($bcNumber)->val())->toBe("0.00");
})->with([0.02222, 0.0222, 0.022, 0.02]);

it('correctly multiplies numbers', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->mul(2)->val())->toBe("0.02")
        ->and($bcNumber->mulIf(2, fn() => true)->val())->toBe("0.02")
        ->and($bcNumber->mul($bcNumber)->val())->toBe("0.00");
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly divides numbers', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->div(2)->val())->toBe("0.01")
        ->and($bcNumber->divIf(2, fn() => true)->val())->toBe("0.01")
        ->and($bcNumber->div($bcNumber)->val())->toBe("1.00");
})->with([0.02222, 0.0222, 0.022, 0.02]);

it('correctly calculates the modulus', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->mod(3)->toInt())->toBe($number % 3)
        ->and($bcNumber->modIf(3, fn() => true)->toInt())->toBe($number % 3);
})->with([10, 20, 30, 40]);

it('correctly calculates the power', function ($number) {
    $bcNumber = new BCNumber($number, 4);
    expect($bcNumber->pow(2)->val())->toBe("0.0001")
        ->and($bcNumber->powIf(2, fn() => true)->val())->toBe("0.0001");
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly calculates the square root', function () {
    $bcNumber = new BCNumber(10, 4);
    expect($bcNumber->sqrt()->val())->toBe("3.1622")
        ->and($bcNumber->sqrtIf(fn() => true)->val())->toBe("3.1622");
});

it('correctly avoids adding if condition is false', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->addIf(0.01, fn() => false)->val())->toBe("0.01");
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly avoids subtracting if condition is false', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->subIf(0.01, fn() => false)->val())->toBe("0.02");
})->with([0.02222, 0.0222, 0.022, 0.02]);

it('correctly avoids multiplying if condition is false', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->mulIf(2, fn() => false)->val())->toBe("0.01");
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly avoids dividing if condition is false', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->divIf(2, fn() => false)->val())->toBe("0.02");
})->with([0.02222, 0.0222, 0.022, 0.02]);

it('correctly avoids calculating the modulus if condition is false', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->modIf(3, fn() => false)->toInt())->toBe($number);
})->with([10, 20, 30, 40]);

it('correctly avoids calculating the power if condition is false', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->powIf(2, fn() => false)->val())->toBe("0.01");
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly avoids calculating the square root if condition is false', function () {
    $bcNumber = new BCNumber(10, 4);
    expect($bcNumber->sqrtIf(fn() => false)->val())->toBe("10.0000");
});

it('correctly scales the number', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->scale(4)->val())->toBe("0.0100");
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly checks if two numbers are equal', function ($number) {
    $bcNumber = new BCNumber($number, 2);
    expect($bcNumber->equals(0.01))->toBeTrue();
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly checks if a number is greater than another', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->greaterThan(0.011))->toBeFalse()
        ->and($bcNumber->greaterThan(0.005))->toBeTrue();
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly checks if a number is greater than or equal to another', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->greaterThanOrEqual($number))->toBeTrue()
        ->and($bcNumber->greaterThanOrEqual(0.001))->toBeTrue();
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly checks if a number is less than another', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->lessThan(0.012))->toBeTrue()
        ->and($bcNumber->lessThan(0.005))->toBeFalse();
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly checks if a number is less than or equal to another', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->lessThanOrEqual($number))->toBeTrue()
        ->and($bcNumber->lessThanOrEqual(0.001))->toBeFalse();
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly checks if a number is zero', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->isZero())->toBeFalse()
        ->and($bcNumber->sub($number)->isZero())->toBeTrue();
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly checks if a number is positive', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->isPositive())->toBeTrue()
        ->and($bcNumber->sub($number * 2)->isPositive())->toBeFalse();
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly checks if a number is negative', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->isNegative())->toBeFalse()
        ->and($bcNumber->sub($number * 2)->isNegative())->toBeTrue();
})->with([0.01111, 0.0111, 0.011, 0.01]);

it('correctly checks if a number is even or not odd', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->isEven())->toBeTrue()
        ->and($bcNumber->isOdd())->toBeFalse();
})->with([2, 4, 6, 8]);

it('correctly checks if a number is odd or not even', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->isOdd())->toBeTrue()
        ->and($bcNumber->isEven())->toBeFalse();
})->with([1, 3, 5, 7]);

it('correctly returns the absolute value of a number', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->abs()->toInt())->toBe(abs($number));
})->with([-2, -4, 3, 6]);

it('correctly returns the negative value of a number', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->negate()->toInt())->toBe(-$number);
})->with([-2, -4, 3, 6]);

it('correctly returns the minimum value between two numbers', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->min(4.6)->toFloat())->toBe((float)min($number, 4.6));
})->with([1, 2, 3, 4]);

it('correctly returns the maximum value between two numbers', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->max(4.6)->toFloat())->toBe((float)max($number, 4.6));
})->with([1, 2, 3, 4]);

it('correctly clamps a number between two values', function ($number) {
    $bcNumber = new BCNumber($number, 3);
    expect($bcNumber->clamp(2, 4)->toFloat())->toBe((float)min(max($number, 2), 4));
})->with([1, 2, 3, 4]);