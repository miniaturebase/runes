<?php

declare(strict_types = 1);

use Pest\Expectation;
use Minibase\Rune\Rune;
use Minibase\Rune\Test\Constraints\HasCodepoint;
use Minibase\Rune\Test\Constraints\HasDecimal;
use Minibase\Rune\Test\Constraints\HasGlyph;
use Minibase\Rune\Test\Constraints\HasName;
use Minibase\Rune\Test\Constraints\IsAscii;
use Minibase\Rune\Test\Constraints\IsUtf16;
use Minibase\Rune\Test\Constraints\IsUtf32;
use Minibase\Rune\Test\Constraints\IsUtf8;
use Minibase\Rune\Test\Constraints\WithinScript;

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeAscii', function () {
    return $this->toMatchConstraint(new IsAscii());
});

expect()->extend('toBeUtf8', function () {
    return $this->toMatchConstraint(new IsUtf8());
});

expect()->extend('toBeUtf16', function () {
    return $this->toMatchConstraint(new IsUtf16());
});

expect()->extend('toBeUtf32', function () {
    return $this->toMatchConstraint(new IsUtf32());
});

expect()->extend('toHaveGlyph', function (string $glyph) {
    return $this->toMatchConstraint(new HasGlyph($glyph));
});

expect()->extend('toHaveCodepoint', function (string $codepoint) {
    return $this->toMatchConstraint(new HasCodepoint($codepoint));
});

expect()->extend('toHaveDecimal', function (int $decimal) {
    return $this->toMatchConstraint(new HasDecimal($decimal));
});

expect()->extend('toBeNamed', function (string $name) {
    return $this->toMatchConstraint(new HasName($name));
});

expect()->extend('toBeWithinScript', function ($script) {
    return $this->toMatchConstraint(new WithinScript($script));
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Assert that the given glyph is ASCII and matches the expected data points.
 *
 * @param string $glyph The single-(multi)-byte character string under test
 * @param string|int ...$rest `string $codepoint`, `int $decimal`, `string $name`, `string $script`
 * @return void
 */
function assertAscii(string $glyph, ...$rest): void
{
    assertCharacterData(expectGlyph($glyph)->toBeAscii(), ...$rest);
}

/**
 * Assert that the given glyph is UTF-8 and matches the expected data points.
 *
 * @param string $glyph The single-(multi)-byte character string under test
 * @param string|int ...$rest `string $codepoint`, `int $decimal`, `string $name`, `string $script`
 * @return void
 */
function assertUtf8(string $glyph, ...$rest): void
{
    assertCharacterData(expectGlyph($glyph)->toBeUtf8(), ...$rest);
}

/**
 * Assert that the given glyph is UTF-16 and matches the expected data points.
 *
 * @param string $glyph The single-(multi)-byte character string under test
 * @param string|int ...$rest `string $codepoint`, `int $decimal`, `string $name`, `string $script`
 * @return void
 */
function assertUtf16(string $glyph, ...$rest): void
{
    assertCharacterData(expectGlyph($glyph)->toBeUtf16(), ...$rest);
}

/**
 * Assert that the given glyph is UTF-32 and matches the expected data points.
 *
 * @param string $glyph The single-(multi)-byte character string under test
 * @param string|int ...$rest `string $codepoint`, `int $decimal`, `string $name`, `string $script`
 * @return void
 */
function assertUtf32(string $glyph, ...$rest): void
{
    assertCharacterData(expectGlyph($glyph)->toBeUtf32(), ...$rest);
}

/**
 * Assert that the given glyph is **not** ASCII but still matches the expected
 * data points.
 *
 * @param string $glyph The single-(multi)-byte character string under test
 * @param string|int ...$rest `string $codepoint`, `int $decimal`, `string $name`, `string $script`
 * @return void
 */
function assertNotAscii(string $glyph, ...$rest): void
{
    assertCharacterData(expectGlyph($glyph)->not()->toBeAscii(), ...$rest);
}

/**
 * Assert that the given glyph is **not** UTF-8 but still matches the expected
 * data points.
 *
 * @param string $glyph The single-(multi)-byte character string under test
 * @param string|int ...$rest `string $codepoint`, `int $decimal`, `string $name`, `string $script`
 * @return void
 */
function assertNotUtf8(string $glyph, ...$rest): void
{
    assertCharacterData(expectGlyph($glyph)->not()->toBeUtf8(), ...$rest);
}

/**
 * Assert that the given glyph is **not** UTF-16 but still matches the expected
 * data points.
 *
 * @param string $glyph The single-(multi)-byte character string under test
 * @param string|int ...$rest `string $codepoint`, `int $decimal`, `string $name`, `string $script`
 * @return void
 */
function assertNotUtf16(string $glyph, ...$rest): void
{
    assertCharacterData(expectGlyph($glyph)->not()->toBeUtf16(), ...$rest);
}

/**
 * Assert that the given glyph is **not** UTF-32 but still matches the expected
 * data points.
 *
 * @param string $glyph The single-(multi)-byte character string under test
 * @param string|int ...$rest `string $codepoint`, `int $decimal`, `string $name`, `string $script`
 * @return void
 */
function assertNotUtf32(string $glyph, ...$rest): void
{
    assertCharacterData(expectGlyph($glyph)->not()->toBeUtf32(), ...$rest);
}

/**
 * Begin a new expectation chain for the given glyph.
 *
 * @param string $glyph The single-(multi)-byte character string under test
 * @return Expectation
 */
function expectGlyph(string $glyph): Expectation
{
    return expect(new Rune($glyph))
        ->toHaveGlyph($glyph);
}

/**
 * Continue an expectation chain asserting that the glyph under test matches
 * the given codepoint, decimal, name, and script values.
 *
 * @param Expectation $expectation An ongoing expectation chain
 * @param string $codepoint The codepoint that the glyph within the expectation chain is expected to have
 * @param int $decimal The expected decimal value of the glyph within the expectation chain
 * @param string $name The expected name of the glyph within the expectation chain
 * @param string $script The script that the glyph within the expectation chain is expected to be within
 * @return void
 */
function assertCharacterData(
    Expectation $expectation,
    string $codepoint,
    int $decimal,
    string $name,
    string $script
): void {
    $expectation
        ->toHaveCodepoint($codepoint)
        ->toHaveDecimal($decimal)
        ->toBeNamed($name)
        ->toBeWithinScript($script);
}
