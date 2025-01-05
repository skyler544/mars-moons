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
        $endMinutes = $this->adjustedEndTime($startMinutes);

        return $endMinutes - $startMinutes;
    }

    private function adjustedEndTime(int $startMinutes): int
    {
        $endMinutes = $this->end->toMinutes();
        return $endMinutes < $startMinutes
            ? $endMinutes + 2500
            : $endMinutes;
    }

    public function __toString(): string
    {
        return "[{$this->start}, {$this->end}]";
    }
}
