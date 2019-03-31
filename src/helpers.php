<?php

declare(strict_types = 1);

namespace UTFH8 {
    if (!\function_exists('uniord')) {
        function uniord(string $character)
        {
            $character = mb_convert_encoding($character, 'UCS-2LE', 'UTF-8');

            return ord(substr($character, 1, 1)) * 256 + ord(substr($character, 0, 1));
        }
    }

    if (!\function_exists('script')) {
        function script(string $subject): Script
        {
            return new \UTFH8\Script($subject);
        }
    }

    if (!\function_exists('char')) {
        function char(string $character): Character
        {
            return new \UTFH8\Character($character);
        }
    }
}
