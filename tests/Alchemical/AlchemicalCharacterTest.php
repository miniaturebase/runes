<?php

declare(strict_types = 1);

namespace UTFH8\Tests\Alchemical;

use UTFH8\Character;

it('can anaylyze alchemical symbols', function (string $glyph, string $codepoint): void {
    expect(new Character($glyph))
        ->toBeUtf16()
        ->toHaveGlyph($glyph)
        ->toHaveCodepoint($codepoint);
})->with(
    'alchemical'
)->group(
    'symbols',
);
