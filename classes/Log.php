<?php

namespace Classes;

final class Log
{
    public static function addEntryToLog(string $message): void
    {
        file_put_contents('log.txt', $message . PHP_EOL, FILE_APPEND);
    }
}
