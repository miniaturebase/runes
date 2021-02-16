<?php

declare(strict_types = 1);

namespace Rune\Test\Datasets;

use Generator;
use Rune\Script;

dataset('emoji.food', function (): Generator {
    yield from [
        'Poultry Leg' => ['🍗', 'U+1F357', 4036988311, 'POULTRY LEG', Script::COMMON],
    ];
});
