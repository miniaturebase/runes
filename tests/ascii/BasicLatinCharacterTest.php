<?php

declare(strict_types = 1);

namespace UTFH8\Tests\Ascii;

use Generator;
use PHPUnit\Framework\TestCase;
use UTFH8\Character;
use UTFH8\Script;

/**
 * Test that all basic latin ASCII characters are analyzed correctly by the
 * libraries Character object.
 */
final class BasicLatinCharacterTest extends TestCase
{
    /**
     * Provide ASCII digit test input to methods using this as a data provider.
     *
     * @return Generator
     */
    public function asciiDigits(): Generator
    {
        yield from [
            'Digit Zero'  => ['0', '\u30', 48, 'DIGIT ZERO', Script::COMMON],
            'Digit One'   => ['1', '\u31', 49, 'DIGIT ONE', Script::COMMON],
            'Digit Two'   => ['2', '\u32', 50, 'DIGIT TWO', Script::COMMON],
            'Digit Three' => ['3', '\u33', 51, 'DIGIT THREE', Script::COMMON],
            'Digit Four'  => ['4', '\u34', 52, 'DIGIT FOUR', Script::COMMON],
            'Digit Five'  => ['5', '\u35', 53, 'DIGIT FIVE', Script::COMMON],
            'Digit Six'   => ['6', '\u36', 54, 'DIGIT SIX', Script::COMMON],
            'Digit Seven' => ['7', '\u37', 55, 'DIGIT SEVEN', Script::COMMON],
            'Digit Eight' => ['8', '\u38', 56, 'DIGIT EIGHT', Script::COMMON],
            'Digit Nine'  => ['9', '\u39', 57, 'DIGIT NINE', Script::COMMON],
        ];
    }

    /**
     * Provide ASCII lowercase alphabet test input to methods using this as a
     * data provider.
     *
     * @return Generator
     */
    public function asciiLowercaseAlphabet(): Generator
    {
        yield from [
            'Latin Small Letter A' => ['a', '\u61', 97, 'LATIN SMALL LETTER A', Script::LATIN],
            'Latin Small Letter B' => ['b', '\u62', 98, 'LATIN SMALL LETTER B', Script::LATIN],
            'Latin Small Letter C' => ['c', '\u63', 99, 'LATIN SMALL LETTER C', Script::LATIN],
            'Latin Small Letter D' => ['d', '\u64', 100, 'LATIN SMALL LETTER D', Script::LATIN],
            'Latin Small Letter E' => ['e', '\u65', 101, 'LATIN SMALL LETTER E', Script::LATIN],
            'Latin Small Letter F' => ['f', '\u66', 102, 'LATIN SMALL LETTER F', Script::LATIN],
            'Latin Small Letter G' => ['g', '\u67', 103, 'LATIN SMALL LETTER G', Script::LATIN],
            'Latin Small Letter H' => ['h', '\u68', 104, 'LATIN SMALL LETTER H', Script::LATIN],
            'Latin Small Letter I' => ['i', '\u69', 105, 'LATIN SMALL LETTER I', Script::LATIN],
            'Latin Small Letter J' => ['j', '\u6a', 106, 'LATIN SMALL LETTER J', Script::LATIN],
            'Latin Small Letter K' => ['k', '\u6b', 107, 'LATIN SMALL LETTER K', Script::LATIN],
            'Latin Small Letter L' => ['l', '\u6c', 108, 'LATIN SMALL LETTER L', Script::LATIN],
            'Latin Small Letter M' => ['m', '\u6d', 109, 'LATIN SMALL LETTER M', Script::LATIN],
            'Latin Small Letter N' => ['n', '\u6e', 110, 'LATIN SMALL LETTER N', Script::LATIN],
            'Latin Small Letter O' => ['o', '\u6f', 111, 'LATIN SMALL LETTER O', Script::LATIN],
            'Latin Small Letter P' => ['p', '\u70', 112, 'LATIN SMALL LETTER P', Script::LATIN],
            'Latin Small Letter Q' => ['q', '\u71', 113, 'LATIN SMALL LETTER Q', Script::LATIN],
            'Latin Small Letter R' => ['r', '\u72', 114, 'LATIN SMALL LETTER R', Script::LATIN],
            'Latin Small Letter S' => ['s', '\u73', 115, 'LATIN SMALL LETTER S', Script::LATIN],
            'Latin Small Letter T' => ['t', '\u74', 116, 'LATIN SMALL LETTER T', Script::LATIN],
            'Latin Small Letter U' => ['u', '\u75', 117, 'LATIN SMALL LETTER U', Script::LATIN],
            'Latin Small Letter V' => ['v', '\u76', 118, 'LATIN SMALL LETTER V', Script::LATIN],
            'Latin Small Letter W' => ['w', '\u77', 119, 'LATIN SMALL LETTER W', Script::LATIN],
            'Latin Small Letter X' => ['x', '\u78', 120, 'LATIN SMALL LETTER X', Script::LATIN],
            'Latin Small Letter Y' => ['y', '\u79', 121, 'LATIN SMALL LETTER Y', Script::LATIN],
            'Latin Small Letter Z' => ['z', '\u7a', 122, 'LATIN SMALL LETTER Z', Script::LATIN],
        ];
    }

    /**
     * Provide ASCII punctuation and symbol test input to methods using this as
     * a data provider.
     *
     * @return Generator
     */
    public function asciiPunctuationAndSymbols(): Generator
    {
        yield from [
            'Space'                                   => [' ', '\u20', 32, 'SPACE', Script::COMMON],
            'Exclamation mark'                        => ['!', '\u21', 33, 'EXCLAMATION MARK', Script::COMMON],
            'Quotation mark'                          => ['"', '\u22', 34, 'QUOTATION MARK', Script::COMMON],
            'Number sign, Hashtag, Octothorpe, Sharp' => ['#', '\u23', 35, 'NUMBER SIGN', Script::COMMON],
            'Dollar sign'                             => ['$', '\u24', 36, 'DOLLAR SIGN', Script::COMMON],
            'Percent sign'                            => ['%', '\u25', 37, 'PERCENT SIGN', Script::COMMON],
            'Ampersand'                               => ['&', '\u26', 38, 'AMPERSAND', Script::COMMON],
            'Apostrophe'                              => ["'", '\u27', 39, 'APOSTROPHE', Script::COMMON],
            'Left parenthesis'                        => ['(', '\u28', 40, 'LEFT PARENTHESIS', Script::COMMON],
            'Right parenthesis'                       => [')', '\u29', 41, 'RIGHT PARENTHESIS', Script::COMMON],
            'Asterisk'                                => ['*', '\u2a', 42, 'ASTERISK', Script::COMMON],
            'Plus sign'                               => ['+', '\u2b', 43, 'PLUS SIGN', Script::COMMON],
            'Comma'                                   => [',', '\u2c', 44, 'COMMA', Script::COMMON],
            'Hyphen-minus'                            => ['-', '\u2d', 45, 'HYPHEN-MINUS', Script::COMMON],
            'Full stop'                               => ['.', '\u2e', 46, 'FULL STOP', Script::COMMON],
            'Slash (Solidus)'                         => ['/', '\u2f', 47, 'SOLIDUS', Script::COMMON],
            'Colon'                                   => [':', '\u3a', 58, 'COLON', Script::COMMON],
            'Semicolon'                               => [';', '\u3b', 59, 'SEMICOLON', Script::COMMON],
            'Less-than sign'                          => ['<', '\u3c', 60, 'LESS-THAN SIGN', Script::COMMON],
            'Equal sign'                              => ['=', '\u3d', 61, 'EQUALS SIGN', Script::COMMON],
            'Greater-than sign'                       => ['>', '\u3e', 62, 'GREATER-THAN SIGN', Script::COMMON],
            'Question mark'                           => ['?', '\u3f', 63, 'QUESTION MARK', Script::COMMON],
            '(Commercial) At sign'                    => ['@', '\u40', 64, 'COMMERCIAL AT', Script::COMMON],
            'Left Square Bracket'                     => ['[', '\u5b', 91, 'LEFT SQUARE BRACKET', Script::COMMON],
            'Backslash (Reverse solidus)'             => ['\\', '\u5c', 92, 'REVERSE SOLIDUS', Script::COMMON],
            'Right Square Bracket'                    => [']', '\u5d', 93, 'RIGHT SQUARE BRACKET', Script::COMMON],
            'Circumflex accent'                       => ['^', '\u5e', 94, 'CIRCUMFLEX ACCENT', Script::COMMON],
            'Low line'                                => ['_', '\u5f', 95, 'LOW LINE', Script::COMMON],
            'Grave accent'                            => ['`', '\u60', 96, 'GRAVE ACCENT', Script::COMMON],
            'Left Curly Bracket'                      => ['{', '\u7b', 123, 'LEFT CURLY BRACKET', Script::COMMON],
            'Vertical bar (line)'                     => ['|', '\u7c', 124, 'VERTICAL LINE', Script::COMMON],
            'Right Curly Bracket'                     => ['}', '\u7d', 125, 'RIGHT CURLY BRACKET', Script::COMMON],
            'Tilde'                                   => ['~', '\u7e', 126, 'TILDE', Script::COMMON],
        ];
    }

    /**
     * Provide ASCII uppercase alphabet test input to methods using this as a
     * data provider.
     *
     * @return Generator
     */
    public function asciiUppercaseAlphabet(): Generator
    {
        yield from [
            'Latin Capital letter A' => ['A', '\u41', 65, 'LATIN CAPITAL LETTER A', Script::LATIN],
            'Latin Capital letter B' => ['B', '\u42', 66, 'LATIN CAPITAL LETTER B', Script::LATIN],
            'Latin Capital letter C' => ['C', '\u43', 67, 'LATIN CAPITAL LETTER C', Script::LATIN],
            'Latin Capital letter D' => ['D', '\u44', 68, 'LATIN CAPITAL LETTER D', Script::LATIN],
            'Latin Capital letter E' => ['E', '\u45', 69, 'LATIN CAPITAL LETTER E', Script::LATIN],
            'Latin Capital letter F' => ['F', '\u46', 70, 'LATIN CAPITAL LETTER F', Script::LATIN],
            'Latin Capital letter G' => ['G', '\u47', 71, 'LATIN CAPITAL LETTER G', Script::LATIN],
            'Latin Capital letter H' => ['H', '\u48', 72, 'LATIN CAPITAL LETTER H', Script::LATIN],
            'Latin Capital letter I' => ['I', '\u49', 73, 'LATIN CAPITAL LETTER I', Script::LATIN],
            'Latin Capital letter J' => ['J', '\u4a', 74, 'LATIN CAPITAL LETTER J', Script::LATIN],
            'Latin Capital letter K' => ['K', '\u4b', 75, 'LATIN CAPITAL LETTER K', Script::LATIN],
            'Latin Capital letter L' => ['L', '\u4c', 76, 'LATIN CAPITAL LETTER L', Script::LATIN],
            'Latin Capital letter M' => ['M', '\u4d', 77, 'LATIN CAPITAL LETTER M', Script::LATIN],
            'Latin Capital letter N' => ['N', '\u4e', 78, 'LATIN CAPITAL LETTER N', Script::LATIN],
            'Latin Capital letter O' => ['O', '\u4f', 79, 'LATIN CAPITAL LETTER O', Script::LATIN],
            'Latin Capital letter P' => ['P', '\u50', 80, 'LATIN CAPITAL LETTER P', Script::LATIN],
            'Latin Capital letter Q' => ['Q', '\u51', 81, 'LATIN CAPITAL LETTER Q', Script::LATIN],
            'Latin Capital letter R' => ['R', '\u52', 82, 'LATIN CAPITAL LETTER R', Script::LATIN],
            'Latin Capital letter S' => ['S', '\u53', 83, 'LATIN CAPITAL LETTER S', Script::LATIN],
            'Latin Capital letter T' => ['T', '\u54', 84, 'LATIN CAPITAL LETTER T', Script::LATIN],
            'Latin Capital letter U' => ['U', '\u55', 85, 'LATIN CAPITAL LETTER U', Script::LATIN],
            'Latin Capital letter V' => ['V', '\u56', 86, 'LATIN CAPITAL LETTER V', Script::LATIN],
            'Latin Capital letter W' => ['W', '\u57', 87, 'LATIN CAPITAL LETTER W', Script::LATIN],
            'Latin Capital letter X' => ['X', '\u58', 88, 'LATIN CAPITAL LETTER X', Script::LATIN],
            'Latin Capital letter Y' => ['Y', '\u59', 89, 'LATIN CAPITAL LETTER Y', Script::LATIN],
            'Latin Capital letter Z' => ['Z', '\u5a', 90, 'LATIN CAPITAL LETTER Z', Script::LATIN],
        ];
    }

    /**
     * Test all basic Latin characters in ASCII for correct analyzed data.
     *
     * @param string $glpyh The character glyph to be analyzed and asserted against.
     * @param string $codepoint The charater's codepoint in the `\u0000` format.
     * @param int $decimal The character's decimal value.
     * @param string $name The programatic name of the character.
     * @param string $script The script that the character belongs to.
     * @return void
     * @dataProvider asciiDigits
     * @dataProvider asciiPunctuationAndSymbols
     * @dataProvider asciiUppercaseAlphabet
     * @dataProvider asciiLowercaseAlphabet
     */
    public function testAsciiBasicLatin(
        string $glyph,
        string $codepoint,
        int $decimal,
        string $name,
        string $script
    ): void {
        $char = new Character($glyph);

        $this->assertTrue($char->isAscii());
        $this->assertEquals($glyph, $char->toString());
        $this->assertEquals($name, $char->getName());
        $this->assertEquals($codepoint, $char->toCodepoint());
        $this->assertEquals($decimal, $char->toDecimal());
        $this->assertEquals($script, $char->getScript());
    }
}
