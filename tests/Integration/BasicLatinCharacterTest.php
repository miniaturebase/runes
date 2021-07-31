<?php

declare(strict_types = 1);

test('ASCII control codes', function (...$glyph): void {
    assertAscii(...$glyph);
})->with(
    'ascii.control',
)->group(
    'ascii',
    'symbols',
);

test('ASCII digits', function (...$glyph): void {
    assertAscii(...$glyph);
    assertUtf8(...$glyph);
    assertNotUtf16(...$glyph);
    assertNotUtf32(...$glyph);
})->with(
    'ascii.digits',
)->group(
    'ascii',
    'digits',
);

test('ASCII lowercase characters', function (...$glyph): void {
    assertAscii(...$glyph);
    assertUtf8(...$glyph);
    assertNotUtf16(...$glyph);
    assertNotUtf32(...$glyph);
})->with(
    'ascii.lowercase',
)->group(
    'ascii',
    'lowercase',
);

test('ASCII uppercase characters', function (...$glyph): void {
    assertAscii(...$glyph);
    assertUtf8(...$glyph);
    assertNotUtf16(...$glyph);
    assertNotUtf32(...$glyph);
})->with(
    'ascii.uppercase',
)->group(
    'ascii',
    'uppercase',
);

test('ASCII punctuation and symbols', function (...$glyph): void {
    assertAscii(...$glyph);
    assertUtf8(...$glyph);
    assertNotUtf16(...$glyph);
    assertNotUtf32(...$glyph);
})->with(
    'ascii.punctuation',
)->group(
    'ascii',
    'symbols',
);
