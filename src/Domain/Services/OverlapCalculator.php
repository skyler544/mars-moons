<?php

namespace Mars\Domain\Services;

use Mars\Domain\Interfaces\RotationInterface;
use Mars\Domain\Time\Interval;

class OverlapCalculator
{
    public function __construct(
        private RotationInterface $rotationService
    ) {
    }

    public function overlapDuration(): int
    {
        $deimosRotated = $this->rotationService->deimosRotated();
        $phobosRotated = $this->rotationService->phobosRotated();

        $start = max($deimosRotated->start(), $phobosRotated->start());
        $end = min($deimosRotated->end(), $phobosRotated->end());

        return max(0, $end - $start);
    }
}
