<?php

declare(strict_types = 1);

namespace UTFH8\Tests\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint to match UTF-8 with.
 */
final class IsUtf8 extends Constraint
{
    public function matches($other): bool
    {
        return $other->isUtf8();
    }

    public function toString(): string
    {
        return 'is a UTF-8 encoded glpyh';
    }
}
