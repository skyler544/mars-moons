<?php

namespace Mars\Application;

use Mars\Domain\Services\IntervalService;
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
        echo "Original Deimos Interval: {$deimosInterval}\n";
        echo "Original Phobos Interval: {$phobosInterval}\n";

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
        echo "\n---\n";
        echo "Example of debug output:";
        $this->calculateOverlapDurationWithOutput(
            IntervalService::createInterval(0, 0, 1, 40),
            IntervalService::createInterval(0, 30, 2, 0)
        );
        $this->calculateOverlapDurationWithOutput(
            IntervalService::createInterval(1, 0, 5, 0),
            IntervalService::createInterval(2, 30, 8, 0)
        );

        echo "\n---\n";
        echo "Example of non-debug return value: "
             . $this->calculateOverlapDuration(
                 IntervalService::createInterval(8, 14, 1, 40),
                 IntervalService::createInterval(0, 30, 2, 0)
             );
        echo "\n---\n";
    }
}
