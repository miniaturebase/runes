<?php

declare(strict_types = 1);

use UTFH8\Character;
use UTFH8\Script;

if (!\function_exists('uniord')) {
    function uniord(string $character) {
        $character = mb_convert_encoding($character, 'UCS-2LE', 'UTF-8');

        return ord(substr($character, 1, 1)) * 256 + ord(substr($character, 0, 1));
    }
}

if (!\function_exists('script')) {
    /**
     * Analyze and determine the scripts used in a given string.
     *
     * @param string $subject The string to analyze
     * @return Script
     */
    function script(string $subject): Script {
        return new Script($subject);
    }
}

if (!\function_exists('char')) {
    /**
     * Analyze a character and call many helpful methods for interacting with
     * the glyph.
     *
     * @param string $character A single string character to analyze
     * @return Character
     */
    function char(string $character): Character {
        return new Character($character);
    }
}
