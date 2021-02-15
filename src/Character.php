<?php

declare(strict_types = 1);

namespace UTFH8;

use IntlChar;
use LogicException;
use Normalizer;
use RuntimeException;
use UnexpectedValueException;

final class Character
{
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

    const BINARY_FORMAT = 'H*';

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

    const CODEPOINT_ASCII = 'U+%04d';

    const CODEPOINT_UNICODE = 'U+%04X';

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

    const ENCODING_ASCII = 'ASCII';

    const ENCODING_UTF16 = 'UTF-16';

    const ENCODING_UTF32 = 'UTF-32';

    const ENCODING_UTF8 = 'UTF-8';

    private $bidirectionalClass;

    private $blockCode;

    private $bytes;

    private $category;

    private $combiningClass;

    private $encoding;

    private $glyph;

    private $isMirrored;

    private $name;

    private $script;

    private $version;

    public function __construct(string $character, bool $detectScript = true)
    {
        $this->setCharacterData($character, $detectScript);
    }

    public function __toString(): string
    {
        return $this->glyph;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getScript(): string
    {
        return $this->script;
    }

    public function isAscii(): bool
    {
        return mb_check_encoding($this->glyph, self::ENCODING_ASCII);
    }

    public function isUtf16(): bool
    {
        return mb_check_encoding($this->glyph, self::ENCODING_UTF16);
    }

    public function isUtf32(): bool
    {
        return mb_check_encoding($this->glyph, self::ENCODING_UTF32);
    }

    public function isUtf8(): bool
    {
        return mb_check_encoding($this->glyph, self::ENCODING_UTF8);
    }

    public function length(): int
    {
        return mb_strlen($this->glyph);
    }

    public function size(): int
    {
        return strlen($this->glyph);
    }

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

    public function toBinary(): string
    {
        return base_convert(unpack(self::BINARY_FORMAT, $this->glyph)[1], 16, 2);
    }

    public function toCodepoint(): string
    {
        return sprintf(...(self::ENCODING_ASCII === $this->encoding)
            ? [self::CODEPOINT_ASCII, $this->toHex()]
            : [self::CODEPOINT_UNICODE, IntlChar::ord($this->glyph)]);
    }

    public function toDecimal(): int
    {
        return bindec($this->toBinary());
    }

    public function toHex(): string
    {
        return bin2hex($this->glyph);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }

    public function toString(): string
    {
        return (string) $this;
    }

    public function toUtf16($toInt = false)
    {
        return $this->convertUtfEncoding(self::ENCODING_UTF16, $toInt);
    }

    public function toUtf32($toInt = false)
    {
        return $this->convertUtfEncoding(self::ENCODING_UTF32, $toInt);
    }

    public function toUtf8($toInt = false)
    {
        return $this->convertUtfEncoding(self::ENCODING_UTF8, $toInt);
    }

    private function checkSize(): self
    {
        $maxBytes = (self::ENCODING_UTF16 == $this->encoding) ? 4 : 1;

        if ($this->bytes <= 0 || $this->bytes > $maxBytes) {
            throw new UnexpectedValueException("Characters must only have a maximum byte size of {$maxBytes}, received {$this->bytes}.");
        }

        return $this;
    }

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

    private function detectBidirectionalClass(): self
    {
        $this->bidirectionalClass = self::BIDIRECTIONAL_CLASSES[IntlChar::charDirection($this->glyph)] ?? IntlChar::CHAR_DIRECTION_LEFT_TO_RIGHT;

        return $this;
    }

    private function detectBlockCode(): self
    {
        $this->blockCode = IntlChar::getBlockCode($this->glyph);

        return $this;
    }

    private function detectBytes(): self
    {
        $this->bytes = \mb_strlen($this->glyph, $this->encoding);

        return $this;
    }

    private function detectCategory(): self
    {
        $this->category = self::CHARACTER_CATEGORIES[IntlChar::charType($this->glyph)] ?? IntlChar::CHAR_CATEGORY_UNASSIGNED;

        return $this;
    }

    private function detectCombiningClass(): self
    {
        $this->combiningClass = IntlChar::getCombiningClass($this->glyph);

        return $this;
    }

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

    private function detectIsMirrored(): self
    {
        $this->isMirrored = IntlChar::isMirrored($this->glyph);

        return $this;
    }

    private function detectName(): self
    {
        $this->name = IntlChar::charName($this->glyph);

        if (empty($this->name) and 'Cc' === $this->category) {
            $this->name = self::CONTROL_CODE_NAMES[$this->glyph] ?? '';
        }

        return $this;
    }

    private function detectScript(): self
    {
        $this->script = (string) new Script($this);

        return $this;
    }

    private function detectVersion(): self
    {   
        $this->version = implode('.', IntlChar::charAge($this->glyph) ?? ['0']);

        return $this;
    }

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
