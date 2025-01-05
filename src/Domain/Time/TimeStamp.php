<?php

namespace Mars\Domain\Time;

class TimeStamp
{
    public function __construct(
        private readonly int $hour,
        private readonly int $minute,
    ) {
        $this->validateTimeStamp($hour, $minute);
    }

    public function hour(): int
    {
        return $this->hour;
    }

    public function minute(): int
    {
        return $this->minute;
    }

    public function toMinutes(): int
    {
        return $this->hour() * 100 + $this->minute();
    }

    private function validateTimeStamp(int $hour, int $minute): void
    {
        if (! $this->isValid($hour, $minute)) {
            throw new \InvalidArgumentException(
                "Invalid Martian timestamp: {$hour}:{$minute}"
            );
        }
    }

    private function isValid(int $hour, int $minute): bool
    {
        return $hour >= 0 && $hour < 25 && $minute >= 0 && $minute < 100;
    }

    public function __toString(): string
    {
        return "{$this->hour()}:{$this->minute()}";
    }
}
