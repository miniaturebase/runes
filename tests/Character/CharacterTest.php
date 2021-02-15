<?php

declare(strict_types = 1);

use UTFH8\Character;

it('only constructs with 1-(multi)-byte character input', function (): void {
    new Character('asdf');
})->throws(
    UnexpectedValueException::class,
    'Characters must only have a maximum byte size of 1, received 4.'
);

it('accepts single-byte characters')
    ->expect((new Character(chr(rand(0, 127))))->size())
    ->toBe(1);

it('accepts multi-byte characters', function (string $glyph, int $bytes): void {
    $char = new Character($glyph);
    
    expect($char->size())
        ->toBe($bytes)
        ->and($char->length())
        ->toBe(1);
})->with([
    ['ß', 2],
    // ['✔︎', 2],
    ['λ', 2],
    ['÷', 2],
    ['₩', 3],
    ['👍', 4],
]);
