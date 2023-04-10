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

    public function __toString(): string
    {
        return $this->value;
    }

    public function toFloat(): float
    {
        return (float)$this->value;
    }

    public function toInt(): int
    {
        return (int)$this->value;
    }

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

    public function sqrt(): BCNumber
    {
        return new BCNumber(
            bcsqrt(
                $this->value,
                $this->scale
            )
        );
    }

    public function addIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->add($number);
        }

        return $this;
    }
    
    public function subIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->sub($number);
        }

        return $this;
    }
    
    public function mulIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->mul($number);
        }

        return $this;
    }
    
    public function divIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->div($number);
        }

        return $this;
    }
    
    public function modIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->mod($number);
        }

        return $this;
    }
    
    public function powIf(BCNumber|int|float $number, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->pow($number);
        }

        return $this;
    }
    
    public function powmodIf(BCNumber|int|float $number, BCNumber|int|float $modulus, Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->powmod($number, $modulus);
        }

        return $this;
    }
    
    public function sqrtIf(Closure|bool $condition = true): BCNumber
    {
        $condition = $condition instanceof Closure ? $condition() : $condition;

        if ($condition) {
            return $this->sqrt();
        }

        return $this;
    }

    public function scale(int $scale): BCNumber
    {
        return new BCNumber($this->value, $scale);
    }

    #########################
    # Comparison operations #
    #########################

    private function comp(BCNumber|int|float $number): int
    {
        return bccomp(
            $this->value,
            self::from($number, $this->scale)->value,
            $this->scale
        );
    }

    public function equals(BCNumber|int|float $number): bool
    {
        return $this->comp($number) === 0;
    }

    public function greaterThan(BCNumber|int|float $number): bool
    {
        return $this->comp($number) === 1;
    }

    public function greaterThanOrEqual(BCNumber|int|float $number): bool
    {
        return $this->comp($number) >= 0;
    }

    public function lessThan(BCNumber|int|float $number): bool
    {
        return $this->comp($number) === -1;
    }

    public function lessThanOrEqual(BCNumber|int|float $number): bool
    {
        return $this->comp($number) <= 0;
    }

    public function isZero(): bool
    {
        return $this->equals(0);
    }

    public function isPositive(): bool
    {
        return $this->greaterThan(0);
    }

    public function isNegative(): bool
    {
        return $this->lessThan(0);
    }

    public function isEven(): bool
    {
        return $this->mod(2)->isZero();
    }

    public function isOdd(): bool
    {
        return !$this->isEven();
    }

    public function abs(): BCNumber
    {
        return $this->isNegative() ? $this->mul(-1) : $this;
    }

    public function negate(): BCNumber
    {
        return $this->mul(-1);
    }

    public function min(BCNumber|int|float $number): BCNumber
    {
        return $this->lessThan($number) ? $this : self::from($number, $this->scale);
    }

    public function max(BCNumber|int|float $number): BCNumber
    {
        return $this->greaterThan($number) ? $this : self::from($number, $this->scale);
    }

    public function clamp(BCNumber|int|float $min, BCNumber|int|float $max): BCNumber
    {
        return $this->min($max)->max($min);
    }
}