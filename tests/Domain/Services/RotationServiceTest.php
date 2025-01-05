<?php

namespace Mars\Domain\Services;

use Mars\Domain\Time\NormalizedInterval;
use Mars\Domain\Time\Interval;
use PHPUnit\Framework\TestCase;

class RotationServiceTest extends TestCase
{
    /**
     * @return array<int, array{Interval, Interval, NormalizedInterval, NormalizedInterval}>
     */
    public static function rotationDataProvider(): array
    {
        return [
            [
                IntervalHelperService::createInterval(0, 0, 1, 0),
                IntervalHelperService::createInterval(2, 0, 3, 0),
                new NormalizedInterval(0, 100),
                new NormalizedInterval(200, 300),
            ],
            [
                IntervalHelperService::createInterval(1, 0, 2, 0),
                IntervalHelperService::createInterval(3, 0, 4, 0),
                new NormalizedInterval(0, 100),
                new NormalizedInterval(200, 300),
            ],
            [
                IntervalHelperService::createInterval(24, 90, 0, 10),
                IntervalHelperService::createInterval(0, 0, 0, 10),
                new NormalizedInterval(0, 20),
                new NormalizedInterval(10, 20),
            ]
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('rotationDataProvider')]
    public function testRotationService(
        Interval $deimos,
        Interval $phobos,
        NormalizedInterval $expectedDeimos,
        NormalizedInterval $expectedPhobos
    ): void {
        $rotationService = new RotationService($deimos, $phobos);

        $this->assertEquals(
            $expectedDeimos->start(),
            $rotationService->deimosRotated()->start()
        );
        $this->assertEquals(
            $expectedDeimos->end(),
            $rotationService->deimosRotated()->end()
        );

        $this->assertEquals(
            $expectedPhobos->start(),
            $rotationService->phobosRotated()->start()
        );
        $this->assertEquals(
            $expectedPhobos->end(),
            $rotationService->phobosRotated()->end()
        );
    }
}
