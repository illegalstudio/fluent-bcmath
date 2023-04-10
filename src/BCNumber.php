<?php

final class BCNumber
{
    private string $value;
    private int    $scale;

    public function __construct(string|int|float $value, int $scale = 0)
    {
        $this->value = bcmul((string)$value, '1', $scale);
        $this->scale = $scale;
    }

    ###################
    # Data conversion #
    ###################

    /**
     * Converts the number to a string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Converts the number to a float
     */
    public function toFloat(): float
    {
        return (float)$this->value;
    }

    /**
     * Converts the number to an int
     */
    public function toInt(): int
    {
        return (int)$this->value;
    }

    /**
     * Creates a new BCNumber from a number
     * If the number is already a BCNumber, it will be returned as is
     */
    private static function from(BCNumber|int|float $number, int $scale = 0): BCNumber
    {
        if (!$number instanceof BCNumber) {
            return new BCNumber($number, $scale);
        }

        return $number;
    }

    #########################
    # Arithmetic operations #
    #########################

    /**
     * Adds a number to the current number
     */
    public function add(BCNumber|int|float $number): BCNumber
    {
        return new BCNumber(
            bcadd(
                $this->value,
                self::from($number, $this->scale)->value,
                $this->scale
            )
        );
    }

    /**
     * Subtracts a number from the current number
     */
    public function sub(BCNumber|int|float $number): BCNumber
    {
        return new BCNumber(
            bcsub(
                $this->value,
                self::from($number, $this->scale)->value,
                $this->scale
            )
        );
    }

    /**
     * Multiplies the current number by a number
     */
    public function mul(BCNumber|int|float $number): BCNumber
    {
        return new BCNumber(
            bcmul(
                $this->value,
                self::from($number, $this->scale)->value,
                $this->scale
            )
        );
    }

    /**
     * Divides the current number by a number
     */
    public function div(BCNumber|int|float $number): BCNumber
    {
        return new BCNumber(
            bcdiv(
                $this->value,
                self::from($number, $this->scale)->value,
                $this->scale
            )
        );
    }

    /**
     * Calculates the modulus of the current number by a number
     */
    public function mod(BCNumber|int|float $number): BCNumber
    {
        return new BCNumber(
            bcmod(
                $this->value,
                self::from($number, $this->scale)->value,
                $this->scale
            )
        );
    }

    /**
     * Calculates the power of the current number by a number
     */
    public function pow(BCNumber|int|float $number): BCNumber
    {
        return new BCNumber(
            bcpow(
                $this->value,
                self::from($number, $this->scale)->value,
                $this->scale
            )
        );
    }

    /**
     * Calculates the power of the current number by a number, reduced by a specified modulus
     */
    public function powmod(BCNumber|int|float $number, BCNumber|int|float $modulus): BCNumber
    {
        return new BCNumber(
            bcpowmod(
                $this->value,
                self::from($number, $this->scale)->value,
                self::from($modulus, $this->scale)->value,
                $this->scale
            )
        );
    }

    /**
     * Calculates the square root of the current number
     */
    public function sqrt(): BCNumber
    {
        return new BCNumber(
            bcsqrt(
                $this->value,
                $this->scale
            )
        );
    }

    ############################
    # Arithmetic operations if #
    ############################

    /**
     * Adds a number to the current number if the condition is true
     */
    public function addIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->add($number);
        }

        return $this;
    }

    /**
     * Subtracts a number from the current number if the condition is true
     */
    public function subIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->sub($number);
        }

        return $this;
    }

    /**
     * Multiplies the current number by a number if the condition is true
     */
    public function mulIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->mul($number);
        }

        return $this;
    }

    /**
     * Divides the current number by a number if the condition is true
     */
    public function divIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->div($number);
        }

        return $this;
    }

    /**
     * Calculates the modulus of the current number by a number if the condition is true
     */
    public function modIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->mod($number);
        }

        return $this;
    }

    /**
     * Calculates the power of the current number by a number if the condition is true
     */
    public function powIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->pow($number);
        }

        return $this;
    }

    /**
     * Calculates the power of the current number by a number, reduced by a specified modulus if the condition is true
     */
    public function powmodIf(BCNumber|int|float $number, BCNumber|int|float $modulus, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->powmod($number, $modulus);
        }

        return $this;
    }

    /**
     * Calculates the square root of the current number if the condition is true
     */
    public function sqrtIf(Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->sqrt();
        }

        return $this;
    }

    /**
     * Re-scales the current number to a new scale
     */
    public function scale(int $scale): BCNumber
    {
        return new BCNumber($this->value, $scale);
    }

    #########################
    # Comparison operations #
    #########################

    /**
     * Compares the current number with a number.
     * Used internally for comparison operations.
     */
    private function comp(BCNumber|int|float $number): int
    {
        return bccomp(
            $this->value,
            self::from($number, $this->scale)->value,
            $this->scale
        );
    }

    /**
     * Checks if the current number is equal to a number
     */
    public function equals(BCNumber|int|float $number): bool
    {
        return $this->comp($number) === 0;
    }

    /**
     * Checks if the current number is greater than a number
     */
    public function greaterThan(BCNumber|int|float $number): bool
    {
        return $this->comp($number) === 1;
    }

    /**
     * Checks if the current number is greater than or equal to a number
     */
    public function greaterThanOrEqual(BCNumber|int|float $number): bool
    {
        return $this->comp($number) >= 0;
    }

    /**
     * Checks if the current number is less than a number
     */
    public function lessThan(BCNumber|int|float $number): bool
    {
        return $this->comp($number) === -1;
    }

    /**
     * Checks if the current number is less than or equal to a number
     */
    public function lessThanOrEqual(BCNumber|int|float $number): bool
    {
        return $this->comp($number) <= 0;
    }

    /**
     * Checks if the current number is zero
     */
    public function isZero(): bool
    {
        return $this->equals(0);
    }

    /**
     * Checks if the current number is positive
     */
    public function isPositive(): bool
    {
        return $this->greaterThan(0);
    }

    /**
     * Checks if the current number is negative
     */
    public function isNegative(): bool
    {
        return $this->lessThan(0);
    }

    /**
     * Checks if the current number is even
     */
    public function isEven(): bool
    {
        return $this->mod(2)->isZero();
    }

    /**
     * Checks if the current number is odd
     */
    public function isOdd(): bool
    {
        return !$this->isEven();
    }

    /**
     * Returns the absolute value of the current number
     */
    public function abs(): BCNumber
    {
        return $this->isNegative() ? $this->mul(-1) : $this;
    }

    /**
     * Returns the negated value of the current number
     */
    public function negate(): BCNumber
    {
        return $this->mul(-1);
    }

    /**
     * Returns the minimum of the current number and a number
     */
    public function min(BCNumber|int|float $number): BCNumber
    {
        return $this->lessThan($number) ? $this : self::from($number, $this->scale);
    }

    /**
     * Returns the maximum of the current number and a number
     */
    public function max(BCNumber|int|float $number): BCNumber
    {
        return $this->greaterThan($number) ? $this : self::from($number, $this->scale);
    }

    /**
     * Clamps the current number between a minimum and a maximum
     */
    public function clamp(BCNumber|int|float $min, BCNumber|int|float $max): BCNumber
    {
        return $this->min($max)->max($min);
    }
}