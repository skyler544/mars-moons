<?php

namespace Mars\Domain\Services;

use Mars\Domain\Time\TimeStamp;
use Mars\Domain\Time\Interval;

class IntervalHelperService
{
    public static function createInterval(
        int $startHour,
        int $startMinute,
        int $endHour,
        int $endMinute
    ): Interval {
        return new Interval(
            new TimeStamp($startHour, $startMinute),
            new TimeStamp($endHour, $endMinute)
        );
    }
}
