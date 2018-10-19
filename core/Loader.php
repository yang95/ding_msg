<?php


class Loader
{
    static $C;

    static function get($key)
    {
        if (self::has($key)) {
            return self::$C[$key];
        }
        return null;
    }

    static function has($key)
    {
        return isset(self::$C[$key]) ? self::$C[$key] : null;
    }

    static function build($key, $val)
    {
        return self::$C[$key] = $val;
    }

    static function init()
    {
        spl_autoload_register(function ($class) {
            if (is_file(self::get("CORE_PATH") . '/' . $class . ".php")) {
                return require self::get("CORE_PATH") . '/' . $class . ".php";
            }
            if (is_file(self::get("SRC_PATH") . '/' . $class . ".php")) {
                return require self::get("SRC_PATH") . '/' . $class . ".php";
            } else {
                exit($class . " not found");
            }
        });
    }
}