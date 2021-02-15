<?php

declare(strict_types = 1);

namespace UTFH8\Tests\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint to match ASCII with.
 */
final class IsAscii extends Constraint
{
    public function matches($other): bool
    {
        return $other->isAscii();
    }

    public function toString(): string
    {
        return 'is an ASCII encoded glpyh';
    }
}
