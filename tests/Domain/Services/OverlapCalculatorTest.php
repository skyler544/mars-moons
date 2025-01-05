<?php

namespace Mars\Domain\Services;

use Mars\Domain\Time\Interval;
use PHPUnit\Framework\TestCase;

class OverlapCalculatorTest extends TestCase
{
    /**
     * @return array<int, array{Interval, Interval, int}>
     */
    public static function overlapDurationProvider(): array
    {
        return [
            // Full overlap: same intervals
            [
                IntervalService::createInterval(0, 0, 1, 0),
                IntervalService::createInterval(0, 0, 1, 0),
                100
            ],
            // Partial overlap: one ends before the other
            [
                IntervalService::createInterval(0, 0, 1, 0),
                IntervalService::createInterval(0, 0, 0, 50),
                50
            ],
            // Full overlap: one entirely within the other
            [
                IntervalService::createInterval(0, 0, 2, 0),
                IntervalService::createInterval(0, 50, 1, 50),
                100
            ],
            // Midnight crossing
            [
                IntervalService::createInterval(24, 90, 0, 10),
                IntervalService::createInterval(0, 0, 1, 0),
                10
            ],
            // No overlap
            [
                IntervalService::createInterval(0, 0, 1, 0),
                IntervalService::createInterval(2, 0, 3, 0),
                0
            ],
            // Overlap starting at the same time
            [
                IntervalService::createInterval(0, 0, 1, 0),
                IntervalService::createInterval(0, 0, 1, 0),
                100
            ],
            // Deimos fully overlaps Phobos
            [
                IntervalService::createInterval(0, 0, 2, 0),
                IntervalService::createInterval(0, 50, 1, 50),
                100
            ],
            // Phobos fully overlaps Deimos
            [
                IntervalService::createInterval(0, 0, 1, 0),
                IntervalService::createInterval(0, 0, 2, 0),
                100
            ],
            // Phobos rises late at night (near midnight)
            [
                IntervalService::createInterval(23, 30, 0, 30),
                IntervalService::createInterval(0, 0, 1, 0),
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
