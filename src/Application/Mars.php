<?php

namespace Mars\Application;

use Mars\Domain\Services\IntervalHelperService;
use Mars\Domain\Services\OverlapCalculator;
use Mars\Domain\Services\RotationService;
use Mars\Domain\Time\Interval;

class Mars
{
    private function calculateOverlapDuration(
        Interval $deimosInterval,
        Interval $phobosInterval
    ): int {
        return (new OverlapCalculator(
            new RotationService(
                $deimosInterval,
                $phobosInterval
            )
        ))->overlapDuration();
    }

    private function calculateOverlapDurationWithOutput(
        Interval $deimosInterval,
        Interval $phobosInterval
    ): void {
        // The RotationService rotates the intervals based on Deimos' moonrise
        $rotationService = new RotationService(
            $deimosInterval,
            $phobosInterval
        );

        // Rotating intervals
        $deimosRotated = $rotationService->deimosRotated();
        $phobosRotated = $rotationService->phobosRotated();

        // Print the original intervals
        echo "\n";
        echo "Original Deimos Interval: {$deimosInterval->__toString()}\n";
        echo "Original Phobos Interval: {$phobosInterval->__toString()}\n";

        // Print the length of time each moon is visible
        echo "\n";
        echo "Deimos Duration: {$deimosInterval->getDurationInMinutes()} minutes\n";
        echo "Phobos Duration: {$phobosInterval->getDurationInMinutes()} minutes\n";

        // Print the rotated intervals
        echo "\n";
        echo "Rotated Deimos Interval: {$deimosRotated}\n";
        echo "Rotated Phobos Interval: {$phobosRotated}\n";

        // Create the OverlapCalculator to calculate overlap duration
        $overlapCalculator = new OverlapCalculator($rotationService);

        // Calculate the overlap duration
        $overlapDuration = $overlapCalculator->overlapDuration();

        // Print the result
        echo "\n";
        echo "Overlap Duration: {$overlapDuration} minutes\n";
    }

    public function run(): void
    {
        $this->calculateOverlapDurationWithOutput(
            IntervalHelperService::createInterval(0, 0, 1, 40),
            IntervalHelperService::createInterval(0, 30, 2, 0)
        );
        $this->calculateOverlapDurationWithOutput(
            IntervalHelperService::createInterval(1, 0, 5, 0),
            IntervalHelperService::createInterval(2, 30, 8, 0)
        );
    }
}
