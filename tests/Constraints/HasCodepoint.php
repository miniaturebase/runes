<?php

declare(strict_types = 1);

namespace Minibase\Rune\Test\Constraints;

/**
 * Constraint to match codepoints with.
 */
final class HasCodepoint extends Constraint
{
    /**
     * The control codepoint value.
     *
     * @var string
     */
    private $codepoint;

    public function __construct(string $codepoint)
    {
        $this->codepoint = $codepoint;
    }

    public function matches($other): bool
    {
        return $other->toCodepoint() === $this->codepoint;
    }

    protected function failureDescription($other): string
    {
        return sprintf(
            '%s\'s (%s) codepoint is equal to the expected codepoint %s',
            $other,
            $other->toCodepoint(),
            $this->exporter()->export($this->codepoint),
        );
    }
}
