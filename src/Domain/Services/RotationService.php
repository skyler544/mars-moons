<?php

namespace Mars\Domain\Services;

use Mars\Domain\Interfaces\RotationInterface;
use Mars\Domain\Time\NormalizedInterval;
use Mars\Domain\Time\Interval;

class RotationService implements RotationInterface
{
    public function __construct(
        private readonly Interval $deimos,
        private readonly Interval $phobos
    ) {
    }

    public function deimosRotated(): Interval
    {
        return $this->rotatedNormalizedInterval($this->deimos);
    }

    public function phobosRotated(): Interval
    {
        return $this->rotatedNormalizedInterval($this->phobos);
    }

    private function rotationOffset(): int
    {
        return max(0, $this->deimos->start());
    }

    private function rotatedNormalizedInterval(Interval $interval): Interval
    {
        return new Interval(
            $this->normalized($interval->start() - $this->rotationOffset()),
            $this->normalized($interval->end() - $this->rotationOffset())
        );
    }

    private function normalized(int $value): int
    {
        return $value < 0
            ? $value + 2500
            : $value;
    }
}
