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
        $startMinutes = $this->start->value();
        $endMinutes = $this->adjustedEndTime();

        return $endMinutes - $startMinutes;
    }

    public function adjustedEndTime(): int
    {
        $endMinutes = $this->end->value();
        return $endMinutes < $this->start->value()
            ? $endMinutes + 2500
            : $endMinutes;
    }

    public function __toString(): string
    {
        return "[{$this->start}, {$this->end}]";
    }
}
