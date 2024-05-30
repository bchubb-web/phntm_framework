<?php

namespace Bchubbweb\PhntmFramework;
use DebugBar\StandardDebugBar;

// singleton to serve StandardDebugBar
class Debug
{
    private static StandardDebugBar $debugBar;

    private function __construct() {}

    public static function getDebugBar(): StandardDebugBar
    {
        if (!isset(self::$debugBar)) {
            self::$debugBar = new StandardDebugBar();
        }

        return self::$debugBar;
    }
}
