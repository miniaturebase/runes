<?php

declare(strict_types = 1);

namespace Minibase\Rune\Test\Constraints;

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
