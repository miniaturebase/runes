<?php

declare(strict_types = 1);

namespace UTFH8\Tests\Integration;

test('runic letter and symbols', function (...$glyph): void {
    assertNotAscii(...$glyph);
    assertUtf8(...$glyph);
    assertNotUtf16(...$glyph);
    assertNotUtf32(...$glyph);
})->with(
    'runic.letters',
);

test('runic punctuation marks', function (...$glyph): void {
    assertNotAscii(...$glyph);
    assertUtf8(...$glyph);
    assertNotUtf16(...$glyph);
    assertNotUtf32(...$glyph);
})->with(
    'runic.punctuation',
);
