<?php

namespace Mars\Domain\Time;

class TimeStamp
{
    public function __construct(
        private readonly int $hour,
        private readonly int $minute,
    ) {
    }

    public function hour(): int
    {
        return $this->hour;
    }

    public function minute(): int
    {
        return $this->minute;
    }
}
