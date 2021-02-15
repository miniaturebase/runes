<?php

declare(strict_types = 1);

namespace UTFH8\Tests\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint to match UTF-32 with.
 */
final class IsUtf32 extends Constraint
{
    public function matches($other): bool
    {
        return $other->isUtf32();
    }

    public function toString(): string
    {
        return 'is a UTF-32 encoded glpyh';
    }
}
