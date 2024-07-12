<?php

if (!function_exists('isLocal')) {
    function isLocal(): bool
    {
        return $_ENV['DEP_ENV'] === 'local';
    }
}

if (!function_exists('isProduction')) {
    function isProduction(): bool
    {
        return $_ENV['DEP_ENV'] === 'production';
    }
}
