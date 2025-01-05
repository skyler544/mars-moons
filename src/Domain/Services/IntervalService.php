<?php

namespace Mars\Domain\Services;

use Mars\Domain\Time\ValidatedTimeStamp;
use Mars\Domain\Time\Interval;
use Mars\Domain\Interfaces\IntervalInterface;

class IntervalService implements IntervalInterface
{
    public static function createInterval(
        int $startHour,
        int $startMinute,
        int $endHour,
        int $endMinute
    ): Interval {
        return new Interval(
            (new ValidatedTimeStamp($startHour, $startMinute))->value(),
            (new ValidatedTimeStamp($endHour, $endMinute))->value()
        );
    }
}
