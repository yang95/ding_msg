<?php


class App extends Loader
{
    static $router = [];

    static function http($key, $val = null)
    {
        if (empty($val)) {
            return self::$router[$key];
        }else{
            return self::$router[$key] = $val;
        }
    }

    static function routerFile($class)
    {
        $class = str_replace(".", "/", $class);
        return require self::get("SRC_PATH") . '/' . $class . ".php";
    }

    public static function gpcs($key)
    {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
        return null;
    }

    static function send($data)
    {
        $hand = self::get("app_run_send");
        if (!is_callable($hand)) {
            $hand = function ($data) {
                if($data){
                    exit(json_encode($data));
                }
            };
        }
        call_user_func($hand, $data);
    }

    public function run()
    {
        $path_hand = self::get("app_run_router");
        $error_hand = self::get("app_run_error");
        if (!is_callable($error_hand)) {
            $error_hand = function ($e) {
                self::send($e);
            };
        }
        if (!is_callable($path_hand)) {
            $path_hand = function () {
                $r = self::gpcs('r');
                if (!$r) {
                    $r = 'index';
                }
                $hand = self::http($r);
                if (!is_callable($hand)) {
                    $hand = function () {
                        return 404;
                    };
                }
                self::send(call_user_func($hand));
            };
        }
        try {
            call_user_func($path_hand);
        } catch (Exception $e) {
            call_user_func($error_hand, $e);
        }
    }

}