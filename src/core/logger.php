<?php

namespace App\Core;

class Logger
{
    public static function log($message)
    {
        $logFile = __DIR__ . '/../../logs/app.log';
        $currentTime = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[$currentTime] $message" . PHP_EOL, FILE_APPEND);
    }
}