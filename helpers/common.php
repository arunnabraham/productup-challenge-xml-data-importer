<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;

//$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/app_log.log', LogLevel::DEBUG));

if (!function_exists('env')) {
    function env($key = null)
    {
        return !empty($key) ? $_ENV[$key] : $_ENV;
    }
}

if (!function_exists('appLogger')) {
    function appLogger($logLevel, string $message)
    {
        $logger = new Logger('applog');
        $logDir = env('APP_LOG_DIR');
        $logFile = env('APP_LOG_FILENAME');
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755);
            touch($logDir . '/' . $logFile);
        }
        $logger->pushHandler(new StreamHandler(realpath($logDir . '/' . $logFile), LogLevel::DEBUG));
        $logger->$logLevel($message);
    }
}
