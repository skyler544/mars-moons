<?php

namespace Mars\Domain\Interfaces;

use Mars\Domain\Time\Interval;
use Mars\Domain\Time\NormalizedInterval;

interface RotationInterface
{
    public function __construct(Interval $deimos, Interval $phobos);

    public function deimosRotated(): NormalizedInterval;
    public function phobosRotated(): NormalizedInterval;
}
