<?php

declare(strict_types = 1);

namespace Rune\Test\Constraints;

/**
 * Constraint to match decimal values with.
 */
final class HasDecimal extends Constraint
{
    /**
     * The control decimal value.
     *
     * @var int
     */
    private $decimal;

    public function __construct(int $decimal)
    {
        $this->decimal = $decimal;
    }

    public function matches($other): bool
    {
        return $other->toDecimal() === $this->decimal;
    }

    protected function failureDescription($other): string
    {
        return sprintf(
            '%s\'s (%d) decimal value is equal to the expected decimal %d',
            $other,
            $other->toDecimal(),
            $this->exporter()->export($this->decimal),
        );
    }
}
