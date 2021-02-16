<?php

declare(strict_types = 1);

namespace Rune\Test\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint to match glyph values with.
 */
final class HasGlyph extends Constraint
{
    /**
     * The control gylph value.
     *
     * @var string
     */
    private $glyph;

    public function __construct(string $glyph)
    {
        $this->glyph = $glyph;
    }

    public function matches($other): bool
    {
        return $other->toString() === $this->glyph;
    }

    public function toString(): string
    {
        return sprintf(
            '\'s glyph is equal to %s',
            $this->exporter()->export($this->glyph),
        );
    }
}
