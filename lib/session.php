<?php

class Session {
    public function __construct() {
        session_start();
    }

    public static function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public static function get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : NULL;
    }

    public static function delete($name) {
        unset($_SESSION[$name]);
    }

    public static function destory() {
        session_destroy();
    }
}
