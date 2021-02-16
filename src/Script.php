<?php

declare(strict_types = 1);

namespace Rune;

use LogicException;

final class Script
{
    const ARABIC = "Arabic";

    const ARMENIAN = "Armenian";

    const BENGALI = "Bengali";

    const BOPOMOFO = "Bopomofo";

    const BRAILLE = "Braille";

    const BUHID = "Buhid";

    const CANADIAN_ABORIGINAL = "Canadian_Aboriginal";

    const CHEROKEE = "Cherokee";

    const COMMON = "Common";

    const CYRILLIC = "Cyrillic";

    const DEVANAGARI = "Devanagari";

    const ETHIOPIC = "Ethiopic";

    const GEORGIAN = "Georgian";

    const GREEK = "Greek";

    const GUJARATI = "Gujarati";

    const GURMUKHI = "Gurmukhi";

    const HAN = "Han";

    const HANGUL = "Hangul";

    const HANUNOO = "Hanunoo";

    const HEBREW = "Hebrew";

    const HIRAGANA = "Hiragana";

    const INHERITED = "Inherited";

    const KANNADA = "Kannada";

    const KATAKANA = "Katakana";

    const KHMER = "Khmer";

    const LAO = "Lao";

    const LATIN = "Latin";

    const LIMBU = "Limbu";

    const MALAYALAM = "Malayalam";

    const MONGOLIAN = "Mongolian";

    const MYANMAR = "Myanmar";

    const OGHAM = "Ogham";

    const ORIYA = "Oriya";

    const RUNIC = "Runic";

    const SCRIPTS = [ # NOTE: high priority scripts are placed at the top
        self::COMMON, self::LATIN, self::CYRILLIC,
        self::ARABIC, self::ARMENIAN,
        self::BENGALI, self::BOPOMOFO, self::BRAILLE, self::BUHID,
        self::CANADIAN_ABORIGINAL, self::CHEROKEE,
        self::DEVANAGARI,
        self::ETHIOPIC,
        self::GEORGIAN, self::GREEK, self::GUJARATI, self::GURMUKHI,
        self::HAN, self::HANGUL, self::HANUNOO, self::HEBREW, self::HIRAGANA,
        self::INHERITED,
        self::KANNADA, self::KATAKANA, self::KHMER,
        self::LAO, self::LIMBU,
        self::MALAYALAM, self::MONGOLIAN, self::MYANMAR,
        self::OGHAM, self::ORIYA,
        self::RUNIC,
        self::SINHALA, self::SYRIAC,
        self::TAGALOG, self::TAGBANWA, self::TAMIL, self::TELUGU, self::THAANA, self::THAI, self::TIBETAN,
        // self::TAILE, # NOTE: doesn't work with PHP PCRE?
        self::YI,
    ];

    const SINHALA = "Sinhala";

    const SYRIAC = "Syriac";

    const TAGALOG = "Tagalog";

    const TAGBANWA = "Tagbanwa";

    const TAILE = "TaiLe";

    const TAMIL = "Tamil";

    const TELUGU = "Telugu";

    const THAANA = "Thaana";

    const THAI = "Thai";

    const TIBETAN = "Tibetan";

    const YI = "Yi";

    /**
     * The current subject's base detected script locale.
     *
     * @var string|null
     */
    private $detected;

    /**
     * A list of objects which reprsent
     *
     * @var object[]|array
     */
    private $inspected;

    /**
     * The previously detected character.
     *
     * @var string|null
     */
    private $previous;

    /**
     * The string to be scrutinized.
     *
     * @var string
     */
    private $subject;

    public function __construct($subject)
    {
        $this->subject = (string) $subject;

        $this->detect();
    }

    public function __toString()
    {
        return $this->detect()->inspected[0]->script;
    }

    public function detect()
    {
        return $this->inspectSubject();
    }

    /**
     * Determine if the current set of inspected characters are all valid (of
     * the same script type).
     *
     * @return bool
     */
    public function isInspectionValid()
    {
        return !mb_strlen($this->subject) || array_reduce($this->inspected, function ($carry, $current) {
            return false !== $carry && true === $current->isValid;
        });
    }

    /**
     * Add the character and script to the list of inspected characters. This
     * method should only be called if the character belonds to the script.
     *
     * @param string $char
     * @param string $script
     * @return self
     */
    private function addInspection(string $char, string $script)
    {
        $this->inspected[] = (object) array_merge(
            (new Rune($char, false))->toArray(),
            ['script' => $script, 'isValid' => $this->isValidScript($script), 'detectedWith' => $this->patternizeScript($script)]
        );

        return $this;
    }

    private function dupePrevious()
    {
        $this->inspected[] = $this->previousInspection();
    }

    /**
     * Process the subject string by inspecting each character individually.
     *
     * @return self
     */
    private function inspectSubject()
    {
        foreach ($this->splitSubjectChars() as $char) {
            array_map(function ($script) use ($char) {
                return $this->processCharWithScript($char, $script);
            }, self::SCRIPTS);
        }

        return $this;
    }

    /**
     * Determine if the given character belongs to the given locale script.
     *
     * @param string $char
     * @param string $script
     * @return bool
     */
    private function isCharInScript(string $char, string $script)
    {
        preg_match_all("/{$this->patternizeScript($script)}/u", $char, $matches);

        return count($matches) && !empty($matches[0]);
    }

    /**
     * Determine if the given character is the same as the previously inspected
     * character.
     *
     * @param string $char The current character being inspected.
     * @return bool
     */
    private function isCharPrevious(string $char)
    {
        return $char === $this->previous;
    }

    /**
     * Determine if the given script type is common (numbers, punctuation, etc).
     *
     * @param string $script The script locale type.
     * @return bool
     */
    private function isCommonScript(string $script)
    {
        return self::COMMON === $script;
    }

    /**
     * Determine if the given script is valid against the detected (base) script
     * for the subject string.
     *
     * @param string $script
     * @return bool
     */
    private function isValidScript(string $script)
    {
        return ($this->isCommonScript($script)
            || (is_null($this->detected) || $this->detected === $script))
            ?? false;
    }

    /**
     * Given a script type, turn it into a valid PCRE unicode script group regex.
     *
     * @see https://www.regular-expressions.info/unicode.html#script
     *
     * @param string $script The type of script that will be turned into a regex pattern.
     * @return string
     * @throws LogicException When unknown script types are received.
     */
    private function patternizeScript(string $script)
    {
        if (!in_array($script, self::SCRIPTS)) {
            throw new LogicException("An unknown script `{$script}` was received.");
        }

        $pattern = "\\p{{$script}}";

        return (self::COMMON != $script) ? "\\p{Common}|{$pattern}" : $pattern;
    }

    private function previousInspection()
    {
        return $this->inspected[abs(count($this->inspected) - 1)];
    }

    /**
     * Given a character and a script, this method will check if the character
     * belongs to the script, and if it does, it will set the detected script
     * if not already,
     *
     * @param string $char The character to process.
     * @param string $script The locale script to process the character with
     * @return self
     */
    private function processCharWithScript(string $char, string $script)
    {
        if ($this->isCharPrevious($char)) {
            if ($this->previousInspection()->script === $script) {
                $this->dupePrevious();
            }

            return $this;
        }

        if (!$this->isCharInScript($char, $script)) {
            return $this;
        }

        return $this->setDetectedScript($script)
            ->addInspection($char, $script)
            ->setPreviousChar($char);
    }

    /**
     * Set the detected script for the subject, that will be used to compare all
     * inspections to.
     *
     * @param string $script The locale script that will be used as the base.
     * @return self
     */
    private function setDetectedScript(string $script)
    {
        $this->detected = (!$this->isCommonScript($script)) ? ($this->detected ?? $script) : $this->detected;

        return $this;
    }

    /**
     * Set the previously inspected character.
     *
     * @param string $char The previous character.
     * @return self
     */
    private function setPreviousChar(string $char)
    {
        $this->previous = $char;

        return $this;
    }

    /**
     * Get a list of each character in the subject string, in order.
     *
     * @return array
     */
    private function splitSubjectChars()
    {
        return preg_split('//u', $this->subject, -1, PREG_SPLIT_NO_EMPTY);
    }
}
