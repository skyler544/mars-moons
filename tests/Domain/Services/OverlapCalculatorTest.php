<?php

namespace Mars\Domain\Services;

use Mars\Domain\Time\TimeStamp;
use Mars\Domain\Time\Interval;
use PHPUnit\Framework\TestCase;

class OverlapCalculatorTest extends TestCase
{
    private static function createInterval(
        int $moonRiseHour,
        int $moonRiseMinute,
        int $moonSetHour,
        int $moonSetMinute
    ): Interval {
        return new Interval(
            new TimeStamp($moonRiseHour, $moonRiseMinute),
            new TimeStamp($moonSetHour, $moonSetMinute)
        );
    }

    /**
     * @return array<int, array{Interval, Interval, int}>
     */
    public static function overlapDurationProvider(): array
    {
        return [
            // Full overlap: same intervals
            [
                self::createInterval(0, 0, 1, 0),
                self::createInterval(0, 0, 1, 0),
                100
            ],
            // Partial overlap: one ends before the other
            [
                self::createInterval(0, 0, 1, 0),
                self::createInterval(0, 0, 0, 50),
                50
            ],
            // Full overlap: one entirely within the other
            [
                self::createInterval(0, 0, 2, 0),
                self::createInterval(0, 50, 1, 50),
                100
            ],
            // Midnight crossing
            [
                self::createInterval(24, 90, 0, 10),
                self::createInterval(0, 0, 1, 0),
                10
            ],
            // No overlap
            [
                self::createInterval(0, 0, 1, 0),
                self::createInterval(2, 0, 3, 0),
                0
            ],
            // Overlap starting at the same time
            [
                self::createInterval(0, 0, 1, 0),
                self::createInterval(0, 0, 1, 0),
                100
            ],
            // Deimos fully overlaps Phobos
            [
                self::createInterval(0, 0, 2, 0),
                self::createInterval(0, 50, 1, 50),
                100
            ],
            // Phobos fully overlaps Deimos
            [
                self::createInterval(0, 0, 1, 0),
                self::createInterval(0, 0, 2, 0),
                100
            ],
            // Phobos rises late at night (near midnight)
            [
                self::createInterval(23, 30, 0, 30),
                self::createInterval(0, 0, 1, 0),
                30
            ],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('overlapDurationProvider')]
    public function testOverlapDuration(
        Interval $deimos,
        Interval $phobos,
        int $expectedDuration
    ): void {
        $calculator = new OverlapCalculator(new RotationService($deimos, $phobos));
        $this->assertEquals(
            $expectedDuration,
            $calculator->overlapDuration()
        );
    }
}
