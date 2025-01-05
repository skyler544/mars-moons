<?php

namespace Mars\Domain\Time;

use InvalidArgumentException;
use Mars\Domain\Time\TimeStamp;
use PHPUnit\Framework\TestCase;

class TimeStampTest extends TestCase
{
    private function assertValidTimeStamp(int $hour, int $minute): void
    {
        $timestamp = new TimeStamp($hour, $minute);
        $this->assertEquals($hour, $timestamp->hour());
        $this->assertEquals($minute, $timestamp->minute());
    }

    /**
     * @return array<int, array<int, int>>
     */
    public static function validTimeStampProvider(): array
    {
        return [
            [  0,  0],
            [ 12,  8],
            [ 15, 69],
            [ 20, 21],
            [ 24, 99]
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('validTimeStampProvider')]
    public function testValidTimestamp(int $hour, int $minute): void
    {
        $this->assertValidTimeStamp($hour, $minute);
    }

    /**
     * @return array<int, array<int, int>>
     */
    public static function invalidTimeStampProvider(): array
    {
        return [
            [ 25,  30],
            [125,  30],
            [ -1,   0],
            [-21,   0],
            [ 20, 100],
            [ 20, 120],
            [ 20,  -1],
            [ 20, -21],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('invalidTimeStampProvider')]
    public function testInvalidTimeStamp(int $hour, int $minute): void
    {
        $this->expectException(InvalidArgumentException::class);
        new TimeStamp($hour, $minute);
    }
}
