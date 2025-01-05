<?php

namespace Mars\Domain\Time;

class NormalizedInterval
{
    public function __construct(
        private readonly int $start,
        private readonly int $end,
    ) {
    }

    public function start(): int
    {
        return $this->normalized($this->start);
    }

    public function end(): int
    {
        return $this->normalized($this->end);
    }

    public function normalized(int $value): int
    {
        return $value < 0
            ? $value + 2500
            : $value;
    }
}
