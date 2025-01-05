<?php

namespace Mars\Domain\Services;

use Mars\Domain\Interfaces\RotationInterface;
use Mars\Domain\Time\NormalizedInterval;
use Mars\Domain\Time\Interval;

// The rotation is always calculated according to Deimos' moonrise
class RotationService implements RotationInterface
{
    public function __construct(
        private readonly Interval $deimos,
        private readonly Interval $phobos
    ) {
    }

    public function deimosRotated(): NormalizedInterval
    {
        return new NormalizedInterval(
            $this->deimos->start()->toMinutes() - $this->rotationOffset(),
            $this->deimos->end()->toMinutes() - $this->rotationOffset()
        );
    }

    public function phobosRotated(): NormalizedInterval
    {
        return new NormalizedInterval(
            $this->phobos->start()->toMinutes() - $this->rotationOffset(),
            $this->phobos->end()->toMinutes() - $this->rotationOffset()
        );
    }

    private function rotationOffset(): int
    {
        return max(0, $this->deimos->start()->toMinutes());
    }
}
