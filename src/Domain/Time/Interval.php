<?php

namespace Mars\Domain\Time;

class Interval
{
    public function __construct(
        private readonly int $start,
        private readonly int $end,
    ) {
    }

    public function start(): int
    {
        return $this->start;
    }

    public function end(): int
    {
        return $this->end;
    }

    public function __toString(): string
    {
        return "[{$this->start}, {$this->end}]";
    }
}
