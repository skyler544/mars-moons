<?php

namespace Mars\Domain\Time;

use Mars\Domain\Time\TimeStamp;
use Mars\Domain\Time\Interval;
use PHPUnit\Framework\TestCase;

class IntervalTest extends TestCase
{
    /**
     * @return array<int, array{TimeStamp, TimeStamp, int}>
     */
    public static function intervalDurationProvider(): array
    {
        return [
            [new TimeStamp(0, 0), new TimeStamp(1, 0), 100],
            [new TimeStamp(0, 0), new TimeStamp(0, 1), 1],
            [new TimeStamp(10, 30), new TimeStamp(12, 30), 200],
            [new TimeStamp(10, 30), new TimeStamp(12, 15), 185],
            [new TimeStamp(23, 50), new TimeStamp(00, 30), 180],
            [new TimeStamp(22, 45), new TimeStamp(01, 15), 370],
            [new TimeStamp(24, 99), new TimeStamp(00, 00), 1],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('intervalDurationProvider')]
    public function testGetDuration(
        TimeStamp $start,
        TimeStamp $end,
        int $expectedDuration
    ): void {
        $interval = new Interval($start, $end);
        $this->assertEquals($expectedDuration, $interval->getDuration());
    }

    /**
     * @return array<int, array{TimeStamp, TimeStamp}>
     */
    public static function intervalProvider(): array
    {
        return [
            [new TimeStamp(10, 15), new TimeStamp(12, 30)],
            [new TimeStamp(0, 0), new TimeStamp(24, 99)],
            [new TimeStamp(23, 59), new TimeStamp(0, 1)],
            [new TimeStamp(12, 0), new TimeStamp(12, 0)],
            [new TimeStamp(10, 0), new TimeStamp(9, 99)],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('intervalProvider')]
    public function testIntervalInitialization(TimeStamp $start, TimeStamp $end): void
    {
        $interval = new Interval($start, $end);

        $this->assertSame($start, $interval->start());
        $this->assertSame($end, $interval->end());
    }
}
