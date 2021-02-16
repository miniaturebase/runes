<?php

declare(strict_types = 1);

namespace Rune\Test\Constraints;

use PHPUnit\Framework\Constraint\Constraint as PHPUnitConstraint;

/**
 * Abstract constraint class for the UTH* library tests.
 */
abstract class Constraint extends PHPUnitConstraint
{
    public function toString(): string
    {
        return '';
    }
}
