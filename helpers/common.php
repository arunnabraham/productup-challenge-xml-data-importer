<?php

if (!function_exists('env')) {
    function env($key = null)
    {
        return !empty($key) ? $_ENV[$key] : $_ENV;
    }
}
