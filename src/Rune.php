<?php

declare(strict_types = 1);

namespace Minibase\Rune;

use IntlChar;
use Normalizer;
use RuntimeException;
use UnexpectedValueException;

/**
 * Analyze a single glyph character to find out everything about it, from it's
 * encoding, direction, script, and even category of the character itself.
 */
final class Rune
{
    /**
     * A map of intl character direction constants to their user-friendly
     * counterpart.
     *
     * The values in the `Bidi_Class` field in `UnicodeData.txt` make use of the
     * short, abbreviated property value aliases for `Bidi_Class`. For convenience
     * in reference, _Table 13_ lists all the abbreviated and long value aliases
     * for `Bidi_Class` values, reproduced from `PropertyValueAliases.txt`, along
     * with a brief description of each category.
     *
     * @see http://www.unicode.org/reports/tr44/#Bidi_Class_Values
     * @see https://www.unicode.org/reports/tr44/#PropertyValueAliases.txt
     */
    const BIDIRECTIONAL_CLASSES = [
        IntlChar::CHAR_DIRECTION_LEFT_TO_RIGHT              => 'L',
        IntlChar::CHAR_DIRECTION_RIGHT_TO_LEFT              => 'R',
        IntlChar::CHAR_DIRECTION_EUROPEAN_NUMBER            => 'EN',
        IntlChar::CHAR_DIRECTION_EUROPEAN_NUMBER_SEPARATOR  => 'ES',
        IntlChar::CHAR_DIRECTION_EUROPEAN_NUMBER_TERMINATOR => 'ET',
        IntlChar::CHAR_DIRECTION_ARABIC_NUMBER              => 'AN',
        IntlChar::CHAR_DIRECTION_COMMON_NUMBER_SEPARATOR    => 'CS',
        IntlChar::CHAR_DIRECTION_BLOCK_SEPARATOR            => 'B',
        IntlChar::CHAR_DIRECTION_SEGMENT_SEPARATOR          => 'S',
        IntlChar::CHAR_DIRECTION_WHITE_SPACE_NEUTRAL        => 'WS',
        IntlChar::CHAR_DIRECTION_OTHER_NEUTRAL              => 'ON',
        IntlChar::CHAR_DIRECTION_LEFT_TO_RIGHT_EMBEDDING    => 'LRE',
        IntlChar::CHAR_DIRECTION_LEFT_TO_RIGHT_OVERRIDE     => 'LRO',
        IntlChar::CHAR_DIRECTION_RIGHT_TO_LEFT_ARABIC       => 'AL',
        IntlChar::CHAR_DIRECTION_RIGHT_TO_LEFT_EMBEDDING    => 'RLE',
        IntlChar::CHAR_DIRECTION_RIGHT_TO_LEFT_OVERRIDE     => 'RLO',
        IntlChar::CHAR_DIRECTION_POP_DIRECTIONAL_FORMAT     => 'PDF',
        IntlChar::CHAR_DIRECTION_DIR_NON_SPACING_MARK       => 'NSM',
        IntlChar::CHAR_DIRECTION_BOUNDARY_NEUTRAL           => 'BN',
        IntlChar::CHAR_DIRECTION_FIRST_STRONG_ISOLATE       => 'FSI',
        IntlChar::CHAR_DIRECTION_LEFT_TO_RIGHT_ISOLATE      => 'LRI',
        IntlChar::CHAR_DIRECTION_RIGHT_TO_LEFT_ISOLATE      => 'RLI',
        IntlChar::CHAR_DIRECTION_POP_DIRECTIONAL_ISOLATE    => 'PDI',
        IntlChar::CHAR_DIRECTION_CHAR_DIRECTION_COUNT       => '?',
    ];

    /**
     * The data format and repeater to unpack binary data with.
     */
    const BINARY_FORMAT = 'H*';

    /**
     * A map of intl character category constants to their user-friendly counterpart.
     */
    const CHARACTER_CATEGORIES = [
        IntlChar::CHAR_CATEGORY_UNASSIGNED             => '?',
        IntlChar::CHAR_CATEGORY_GENERAL_OTHER_TYPES    => '??',
        IntlChar::CHAR_CATEGORY_UPPERCASE_LETTER       => 'Lu',
        IntlChar::CHAR_CATEGORY_LOWERCASE_LETTER       => 'Ll',
        IntlChar::CHAR_CATEGORY_TITLECASE_LETTER       => 'Lt',
        IntlChar::CHAR_CATEGORY_MODIFIER_LETTER        => 'Lm',
        IntlChar::CHAR_CATEGORY_OTHER_LETTER           => 'Lo',
        IntlChar::CHAR_CATEGORY_NON_SPACING_MARK       => 'Mn',
        IntlChar::CHAR_CATEGORY_ENCLOSING_MARK         => 'Me',
        IntlChar::CHAR_CATEGORY_COMBINING_SPACING_MARK => 'Mc',
        IntlChar::CHAR_CATEGORY_DECIMAL_DIGIT_NUMBER   => 'Nd',
        IntlChar::CHAR_CATEGORY_LETTER_NUMBER          => 'Nl',
        IntlChar::CHAR_CATEGORY_OTHER_NUMBER           => 'No',
        IntlChar::CHAR_CATEGORY_SPACE_SEPARATOR        => 'Zs',
        IntlChar::CHAR_CATEGORY_LINE_SEPARATOR         => 'Zl',
        IntlChar::CHAR_CATEGORY_PARAGRAPH_SEPARATOR    => 'Zp',
        IntlChar::CHAR_CATEGORY_CONTROL_CHAR           => 'Cc',
        IntlChar::CHAR_CATEGORY_FORMAT_CHAR            => 'Cf',
        IntlChar::CHAR_CATEGORY_PRIVATE_USE_CHAR       => 'Co',
        IntlChar::CHAR_CATEGORY_SURROGATE              => 'Cs',
        IntlChar::CHAR_CATEGORY_DASH_PUNCTUATION       => 'Pd',
        IntlChar::CHAR_CATEGORY_START_PUNCTUATION      => 'Ps',
        IntlChar::CHAR_CATEGORY_END_PUNCTUATION        => 'Pe',
        IntlChar::CHAR_CATEGORY_CONNECTOR_PUNCTUATION  => 'Pc',
        IntlChar::CHAR_CATEGORY_OTHER_PUNCTUATION      => 'Po',
        IntlChar::CHAR_CATEGORY_MATH_SYMBOL            => 'Sm',
        IntlChar::CHAR_CATEGORY_CURRENCY_SYMBOL        => 'Sc',
        IntlChar::CHAR_CATEGORY_MODIFIER_SYMBOL        => 'Sk',
        IntlChar::CHAR_CATEGORY_OTHER_SYMBOL           => 'So',
        IntlChar::CHAR_CATEGORY_INITIAL_PUNCTUATION    => 'Pi',
        IntlChar::CHAR_CATEGORY_FINAL_PUNCTUATION      => 'Pf',
        IntlChar::CHAR_CATEGORY_CHAR_CATEGORY_COUNT    => '???',
    ];

    /**
     * String format template to generate ASCII codepoints from a glyph.
     */
    const CODEPOINT_ASCII = 'U+%04d';

    /**
     * String format template to generate unicode codepoints from a glyph.
     */
    const CODEPOINT_UNICODE = 'U+%04X';

    /**
     * Hash map of ASCII control code sequences to their character name abbreviation.
     *
     * NOTE: without this map, PHP Intl does not have names for these.
     */
    const CONTROL_CODE_NAMES = [
        "\u{0000}" => 'NUL',
        "\u{0001}" => 'SOH',
        "\u{0002}" => 'STX',
        "\u{0003}" => 'ETX',
        "\u{0004}" => 'EOT',
        "\u{0005}" => 'ENQ',
        "\u{0006}" => 'ACK',
        "\u{0007}" => 'BEL',
        "\u{0008}" => 'BS',
        "\u{0009}" => 'HT',
        "\u{000A}" => 'LF',
        "\u{000B}" => 'VT',
        "\u{000C}" => 'FF',
        "\u{000D}" => 'CR',
        "\u{000E}" => 'SO',
        "\u{000F}" => 'SI',
        "\u{0010}" => 'DLE',
        "\u{0011}" => 'DC1',
        "\u{0012}" => 'DC2',
        "\u{0013}" => 'DC3',
        "\u{0014}" => 'DC4',
        "\u{0015}" => 'NAK',
        "\u{0016}" => 'SYN',
        "\u{0017}" => 'ETB',
        "\u{0018}" => 'CAN',
        "\u{0019}" => 'EM',
        "\u{001A}" => 'SUB',
        "\u{001B}" => 'ESC',
        "\u{001C}" => 'FS',
        "\u{001D}" => 'GS',
        "\u{001E}" => 'RS',
        "\u{001F}" => 'US',
        "\u{007F}" => 'DEL',
    ];

    /**
     * PHP ASCII encoding option string.
     */
    const ENCODING_ASCII = 'ASCII';

    /**
     * PHP UTF-16 encoding option string.
     */
    const ENCODING_UTF16 = 'UTF-16';

    /**
     * PHP UTF-32 encoding option string.
     */
    const ENCODING_UTF32 = 'UTF-32';

    /**
     * PHP UTF-8 encoding option string.
     */
    const ENCODING_UTF8 = 'UTF-8';

    /**
     * The bidirection class of the glyph.
     *
     * @var string
     */
    private $bidirectionalClass;

    /**
     * The code for the block of characters that the glyph belongs to.
     *
     * @var int
     */
    private $blockCode;

    /**
     * The amount of bytes that make up the glpyh.
     *
     * @var int
     */
    private $bytes;

    /**
     * The category of characters that the glyph belongs to.
     *
     * @var string
     */
    private $category;

    /**
     * The combining class of the glyph.
     *
     * @var int
     */
    private $combiningClass;

    /**
     * The highest level of encoding that was detected on the glpyh input.
     *
     * @var string
     */
    private $encoding;

    /**
     * The input glyph that is being analyzed.
     *
     * @var string
     */
    private $glyph;

    /**
     * Is the glyph a mirrored version?
     *
     * @var bool
     */
    private $isMirrored;

    /**
     * The official unique unicode character name.
     *
     * @var string
     */
    private $name;

    /**
     * The script that the glyph is apart of.
     *
     * @var string
     */
    private $script;

    /**
     * The version of unicode that the character was introduced in.
     *
     * @var string
     */
    private $version;

    /**
     * Intantiate a new glyph analyzation.
     *
     * @param string $character The string character to analyze
     * @param bool $detectScript Should the character's script also be analyzed
     */
    public function __construct(string $character, bool $detectScript = true)
    {
        $this->setCharacterData($character, $detectScript);
    }

    public function __toString(): string
    {
        return $this->glyph;
    }

    /**
     * Retreive the name of the glyph.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Retreive the script of the glyph.
     *
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }

    /**
     * Is the character encoded as ASCII?
     *
     * @return bool
     */
    public function isAscii(): bool
    {
        return mb_check_encoding($this->glyph, self::ENCODING_ASCII);
    }

    /**
     * Is the character encoded as UTF-16?
     *
     * @return bool
     */
    public function isUtf16(): bool
    {
        return mb_check_encoding($this->glyph, self::ENCODING_UTF16);
    }

    /**
     * Is the character encoded as UTF-32?
     *
     * @return bool
     */
    public function isUtf32(): bool
    {
        return mb_check_encoding($this->glyph, self::ENCODING_UTF32);
    }

    /**
     * Is the character encoded as UTF-8?
     *
     * @return bool
     */
    public function isUtf8(): bool
    {
        return mb_check_encoding($this->glyph, self::ENCODING_UTF8);
    }

    /**
     * The length of the glyph. Should (always) be 1.
     *
     * @return int
     */
    public function length(): int
    {
        return mb_strlen($this->glyph);
    }

    /**
     * The amount of bytes that the glyph contains. Ranges from 1 (`ASCII`) to 4
     * (`UTF-8`, `UTF-16`, `UTF-32`).
     *
     * @return int
     */
    public function size(): int
    {
        return strlen($this->glyph);
    }

    /**
     * Output a hash map of all the glyph's various encodings and representations.
     *
     * @return bool
     */
    public function toArray(): array
    {
        $data = array_merge(\get_object_vars($this), [
            'binary'    => $this->toBinary(),
            'codepoint' => $this->toCodepoint(),
            'decimal'   => $this->toDecimal(),
            'hex'       => $this->toHex(),
            'utf8'      => $this->toUtf8(),
            'utf16'     => $this->toUtf16(),
            'utf32'     => $this->toUtf32(),
        ]);

        ksort($data);

        return $data;
    }

    /**
     * Convert the glyph into it's binary (1's and 0's) notation.
     *
     * @return string
     */
    public function toBinary(): string
    {
        return base_convert(unpack(self::BINARY_FORMAT, $this->glyph)[1], 16, 2);
    }

    /**
     * Convert the glyph into it's current encoding's unicode codepoint.
     *
     * @return string
     */
    public function toCodepoint(): string
    {
        return sprintf(...(self::ENCODING_ASCII === $this->encoding)
            ? [self::CODEPOINT_ASCII, $this->toHex()]
            : [self::CODEPOINT_UNICODE, IntlChar::ord($this->glyph)]);
    }

    /**
     * Convert the glyph into it's decimal character value.
     *
     * @return int
     */
    public function toDecimal(): int
    {
        return bindec($this->toBinary());
    }

    /**
     * Convert the glyph into it's hexadecimal notation.
     *
     * @return string
     */
    public function toHex(): string
    {
        return bin2hex($this->glyph);
    }

    /**
     * Return all analyzed data on the glyph in a JSON document.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Return the actual unicode encoded, non-escaped, raw glyph character.
     *
     * @return string
     */
    public function toString(): string
    {
        return (string) $this;
    }

    /**
     * If possible, convert the character encoding to UTF-16.
     *
     * @param bool $toInt Return the evaluated hexadecimal integer?
     * @return string|int
     */
    public function toUtf16($toInt = false)
    {
        return $this->convertUtfEncoding(self::ENCODING_UTF16, $toInt);
    }

    /**
     * If possible, convert the character encoding to UTF-32.
     *
     * @param bool $toInt Return the evaluated hexadecimal integer?
     * @return string|int
     */
    public function toUtf32($toInt = false)
    {
        return $this->convertUtfEncoding(self::ENCODING_UTF32, $toInt);
    }

    /**
     * If possible, convert the character encoding to UTF-8.
     *
     * @param bool $toInt Return the evaluated hexadecimal integer?
     * @return string|int
     */
    public function toUtf8($toInt = false)
    {
        return $this->convertUtfEncoding(self::ENCODING_UTF8, $toInt);
    }

    /**
     * Check that the current glyph's byte size is within allowed memory.
     *
     * @throws UnexpectedValueException
     * @return self
     */
    private function checkSize(): self
    {
        $maxBytes = (self::ENCODING_UTF16 == $this->encoding) ? 4 : 1;

        if ($this->bytes <= 0 || $this->bytes > $maxBytes) {
            throw new UnexpectedValueException("Characters must only have a maximum byte size of {$maxBytes}, received {$this->bytes}.");
        }

        return $this;
    }

    /**
     * If possible, convert the character encoding to the given encoding.
     *
     * @param bool $toInt Return the evaluated hexadecimal integer?
     * @return string|int
     */
    private function convertUtfEncoding(string $encoding, bool $toInt = true)
    {
        $bytes = '';
        $split = ((int) \trim(\substr($encoding, -2, 2), '-')) / 4;

        if ($this->isAscii()) {
            $bytes .= \sprintf("%0{$split}s", $this->toHex());
        } else {
            $glyph = \mb_convert_encoding($this->glyph, $encoding, self::ENCODING_UTF8);
            $size = \strlen($glyph); # NOTE: `mb_strlen($glyph, self::ENCODING_UTF32)` does not work here for all chars

            for ($i = 0; $i < $size; ++$i) {
                $bytes .= \bin2hex(\mb_substr($glyph, $i, 1, self::ENCODING_UTF32));
            }
        }

        return \implode(' ', \array_map(function ($part) use ($toInt) {
            $hex = '0x'.\strtoupper($part);

            return ($toInt) ? (string) \hexdec($hex) : $hex;
        }, \str_split($bytes, $split)));
    }

    /**
     * Detect and set the bidirectional class of the unicode glyph.
     *
     * @return self
     */
    private function detectBidirectionalClass(): self
    {
        $this->bidirectionalClass = self::BIDIRECTIONAL_CLASSES[IntlChar::charDirection($this->glyph)] ?? IntlChar::CHAR_DIRECTION_LEFT_TO_RIGHT;

        return $this;
    }

    /**
     * Detect and set the block code of the unicode glyph.
     *
     * @return self
     */
    private function detectBlockCode(): self
    {
        $this->blockCode = IntlChar::getBlockCode($this->glyph);

        return $this;
    }

    /**
     * Detect and set the byte size of the unicode glyph.
     *
     * @return self
     */
    private function detectBytes(): self
    {
        $this->bytes = \mb_strlen($this->glyph, $this->encoding);

        return $this;
    }

    /**
     * Detect and set the category of the unicode glyph.
     *
     * @return self
     */
    private function detectCategory(): self
    {
        $this->category = self::CHARACTER_CATEGORIES[IntlChar::charType($this->glyph)] ?? IntlChar::CHAR_CATEGORY_UNASSIGNED;

        return $this;
    }

    /**
     * Detect and set the combining class of the unicode glyph.
     *
     * @return self
     */
    private function detectCombiningClass(): self
    {
        $this->combiningClass = IntlChar::getCombiningClass($this->glyph);

        return $this;
    }

    /**
     * Detect and set the encoding of the unicode glyph.
     *
     * @throws RuntimeException
     * @return self
     */
    private function detectEncoding(): self
    {
        $isAscii = $this->isAscii();
        $isUtf8 = $this->isUtf8();
        $isUtf16 = $this->isUtf16();
        // $isUtf32 = $this->isUtf32();

        if (!$isAscii && !$isUtf8 && !$isUtf16) {
            throw new RuntimeException("Unknown encoding for character glyph: `{$this->glyph}`");
        }

        if ($isAscii && !$isUtf8) {
            $this->encoding = self::ENCODING_ASCII;
        } elseif (($isAscii && $isUtf8) || (!$isAscii && $isUtf8 && !$isUtf16)) {
            $this->encoding = self::ENCODING_UTF8;
        } elseif (($isUtf8 && $isUtf16) || (!$isUtf8 && $isUtf16)) {
            $this->encoding = self::ENCODING_UTF16;
        }

        return $this;
    }

    /**
     * Detect and set if the unicode glyph is a mirrored character.
     *
     * @return self
     */
    private function detectIsMirrored(): self
    {
        $this->isMirrored = IntlChar::isMirrored($this->glyph);

        return $this;
    }

    /**
     * Detect and set the name of the unicode glyph.
     *
     * @return self
     */
    private function detectName(): self
    {
        $this->name = IntlChar::charName($this->glyph);

        if (empty($this->name) and 'Cc' === $this->category) {
            $this->name = self::CONTROL_CODE_NAMES[$this->glyph] ?? '';
        }

        return $this;
    }

    /**
     * Detect and set the script that the unicode glyph belongs to.
     *
     * @return self
     */
    private function detectScript(): self
    {
        $this->script = (string) new Script($this);

        return $this;
    }

    /**
     * Detect and set the version of unicode that the glyph was introduced in.
     *
     * @return self
     */
    private function detectVersion(): self
    {
        $this->version = implode('.', IntlChar::charAge($this->glyph) ?? ['0']);

        return $this;
    }

    /**
     * Perform all necessary checks and actions to set internal state of the
     * glyph being analyzed.
     *
     * @param string $character The glyph being analyzed
     * @param bool $detectScript Should the script that the character belongs to, also be analyzed?
     * @return self
     */
    private function setCharacterData(string $character, bool $detectScript): self
    {
        $this->glyph = Normalizer::normalize($character, Normalizer::FORM_C);

        $this->detectEncoding()
            ->detectBytes()
            ->checkSize()
            ->detectBidirectionalClass()
            ->detectBlockCode()
            ->detectCategory()
            ->detectCombiningClass()
            ->detectIsMirrored()
            ->detectName()
            ->detectVersion();

        if ($detectScript) { # INF loops :(
            $this->detectScript();
        }

        return $this;
    }
}
