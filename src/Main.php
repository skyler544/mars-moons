<?php

namespace Mars;

require __DIR__ . '/../vendor/autoload.php';

class Main
{
    public static function main(): void
    {
        (new Mars())->run();
    }
}

if (PHP_SAPI === 'cli') {
    Main::main();
}
