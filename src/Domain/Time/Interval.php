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

    public function getDuration(): int
    {
        $startMinutes = $this->start->toMinutes();
        $endMinutes = $this->adjustedEndTime();

        return $endMinutes - $startMinutes;
    }

    public function adjustedEndTime(): int
    {
        $endMinutes = $this->end->toMinutes();
        return $endMinutes < $this->start->toMinutes()
            ? $endMinutes + 2500
            : $endMinutes;
    }

    public function __toString(): string
    {
        return "[{$this->start}, {$this->end}]";
    }
}
