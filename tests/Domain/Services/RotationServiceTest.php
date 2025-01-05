<?php

namespace Mars\Domain\Services;

use Mars\Domain\Time\Interval;
use PHPUnit\Framework\TestCase;

class RotationServiceTest extends TestCase
{
    /**
     * @return array<int, array{Interval, Interval, Interval, Interval}>
     */
    public static function rotationDataProvider(): array
    {
        return [
            [
                IntervalService::createInterval(0, 0, 1, 0),
                IntervalService::createInterval(2, 0, 3, 0),
                IntervalService::createInterval(0, 0, 1, 0),
                IntervalService::createInterval(2, 0, 3, 0),
            ],
            [
                IntervalService::createInterval(1, 0, 2, 0),
                IntervalService::createInterval(3, 0, 4, 0),
                IntervalService::createInterval(0, 0, 1, 0),
                IntervalService::createInterval(2, 0, 3, 0),
            ],
            [
                IntervalService::createInterval(24, 90, 0, 10),
                IntervalService::createInterval(0, 0, 0, 10),
                IntervalService::createInterval(0, 0, 0, 20),
                IntervalService::createInterval(0, 10, 0, 20),
            ]
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('rotationDataProvider')]
    public function testRotationService(
        Interval $deimos,
        Interval $phobos,
        Interval $expectedDeimos,
        Interval $expectedPhobos
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
