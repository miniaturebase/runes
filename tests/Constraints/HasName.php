<?php

declare(strict_types = 1);

namespace Minibase\Rune\Test\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint to match names with.
 */
final class HasName extends Constraint
{
    /**
     * The control name value.
     *
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function matches($other): bool
    {
        return $other->getName() === $this->name;
    }

    public function toString(): string
    {
        return sprintf(
            '\'s name to be %s',
            $this->exporter()->export($this->name),
        );
    }
}
