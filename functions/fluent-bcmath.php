<?php

use Illegal\FluentBCMath\BCNumber;

/**
 * This function is a helper to create a new BCNumber instance.
 */
function fnum(float|int|string $value, int $scale = 4): BCNumber
{
    return new BCNumber($value, $scale);
}