<?php

declare(strict_types = 1);

namespace UTFH8\Tests\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint to match UTF-16 with.
 */
final class IsUtf16 extends Constraint
{
    public function matches($other): bool
    {
        return $other->isUtf16();
    }

    public function toString(): string
    {
        return 'is a UTF-16 encoded glpyh';
    }
}
