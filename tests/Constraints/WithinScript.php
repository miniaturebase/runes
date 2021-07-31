<?php

declare(strict_types = 1);

namespace Minibase\Rune\Test\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint to match script ranges with.
 */
final class WithinScript extends Constraint
{
    /**
     * The control script value
     *
     * @var string
     */
    private $script;

    public function __construct(string $script)
    {
        $this->script = $script;
    }

    public function matches($other): bool
    {
        return $other->getScript() === $this->script;
    }

    public function toString(): string
    {
        return sprintf(
            'is within the %s script',
            $this->exporter()->export($this->script),
        );
    }
}
