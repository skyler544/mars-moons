<?php

namespace Mars\Domain\Services;

use Mars\Domain\Time\Interval;

class OverlapCalculator
{
    // the rotation is always calculated according to Deimos' moonrise
    public function overlapDuration(Interval $deimos, Interval $phobos): int
    {

        // echo "Deimos: {$deimos->__toString()}\n";
        // echo "Phobos: {$phobos->__toString()}\n";

        $deimosStart = $deimos->start()->toMinutes();
        $phobosStart = $phobos->start()->toMinutes();
        // $rotationOffset = min($deimosStart, $phobosStart);
        $rotationOffset = max(0, $deimosStart);

        // echo "Rotation offset: {$rotationOffset}\n";

        $deimosStart -= $rotationOffset;
        $deimosEnd = $deimos->adjustedEndTime() - $rotationOffset;

        $phobosStart -= $rotationOffset;
        $phobosEnd = $phobos->adjustedEndTime() - $rotationOffset;

        // Adjust any negative values by adding 2500 (the length of a Martian day)
        $deimosStart = $deimosStart < 0 ? $deimosStart + 2500 : $deimosStart;
        $deimosEnd = $deimosEnd < 0 ? $deimosEnd + 2500 : $deimosEnd;

        $phobosStart = $phobosStart < 0 ? $phobosStart + 2500 : $phobosStart;
        $phobosEnd = $phobosEnd < 0 ? $phobosEnd + 2500 : $phobosEnd;

        // echo "Rotated Deimos: [{$deimosStart}, {$deimosEnd}]\n";
        // echo "Rotated Phobos: [{$phobosStart}, {$phobosEnd}]\n";

        $start = max($deimosStart, $phobosStart);
        $end = min($deimosEnd, $phobosEnd);

        return max(0, $end - $start);
    }
}
