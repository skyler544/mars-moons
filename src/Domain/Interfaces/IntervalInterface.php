<?php

namespace Mars\Domain\Interfaces;

use Mars\Domain\Time\Interval;

interface IntervalInterface
{
    public static function createInterval(
        int $startHour,
        int $startMinute,
        int $endHour,
        int $endMinute
    ): Interval;
}
