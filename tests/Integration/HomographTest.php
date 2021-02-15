<?php

declare(strict_types = 1);

namespace UTFH8\Tests\Integration;

use UTFH8\Script;

// Cyrililc
// а, с, е, о, р, х, у
// А, В, С, Е, Н, І, Ј, К, М, О, Р, Ѕ, Т, Х

it('rejects strings with mixed scripts', function (): void {
    expect((new Script('admin'))->isInspectionValid())
        ->toBeTrue()
        ->and((new Script('аdmin'))->isInspectionValid())
        ->toBeFalse();
});
