<?php

declare(strict_types = 1);

namespace UTFH8;

/**
 * Alias for `rune`.
 *
 * @param string $glyph
 * @return Rune
 */
function char(string $glyph): Rune
{
    return rune($glyph);
}

/**
 * Create a `Rune` instance from the given glyph.
 *
 * @param string $glyph
 * @return Rune
 */
function rune(string $glyph): Rune
{
    return new Rune($glyph);
}

/**
 * Create a new `Script` instance from the given string.
 *
 * @param string $subject
 * @return Script
 */
function script(string $subject): Script
{
    return new Script($subject);
}

/**
 * @param string $glyph
 * @return int
 */
function uniord(string $glyph): int
{
    $glyph = mb_convert_encoding($glyph, 'UCS-2LE', 'UTF-8');

    return ord(substr($glyph, 1, 1)) * 256 + ord(substr($glyph, 0, 1));
}
