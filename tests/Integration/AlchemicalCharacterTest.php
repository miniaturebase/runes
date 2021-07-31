<?php

declare(strict_types = 1);

use Minibase\Rune\Rune;

it('can anaylyze alchemical symbols', function (string $glyph, string $codepoint): void {
    expect(new Rune($glyph))
        ->toBeUtf16()
        ->toHaveGlyph($glyph)
        ->toHaveCodepoint($codepoint);
})->with(
    'alchemical'
)->group(
    'symbols',
);
