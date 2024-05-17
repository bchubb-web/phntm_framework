<?php

namespace Bchubbweb\PhntmFramework\Router;

class Method
{
    public static function getMethod(): string
    {
        //return the http method for this request
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isGet(): bool
    {
        return self::getMethod() === 'GET';
    }

    public static function isPost(): bool
    {
        return self::getMethod() === 'POST';
    }

    public static function isPut(): bool
    {
        return self::getMethod() === 'PUT';
    }
    
    public static function isDelete(): bool
    {
        return self::getMethod() === 'DELETE';
    }

    public static function isPatch(): bool
    {
        return self::getMethod() === 'PATCH';
    }

    public static function is(string $method): bool
    {
        return self::getMethod() === strtoupper($method);
    }
}
