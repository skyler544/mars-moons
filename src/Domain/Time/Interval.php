<?php

namespace Mars\Domain\Time;

class Interval
{
    public function __construct(
        private readonly TimeStamp $start,
        private readonly TimeStamp $end,
    ) {
    }

    public function start(): TimeStamp
    {
        return $this->start;
    }

    public function end(): TimeStamp
    {
        return $this->end;
    }

    public function __toString(): string
    {
        return "[{$this->start}, {$this->end}]";
    }
}
