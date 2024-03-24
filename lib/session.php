<?php

/**
 *Session Class 
 **/

/**
 * 0 ----> PHP_SESSION_DISABLED if sessions are disabled.
 * 1 ----> PHP_SESSION_NONE if sessions are enabled, but none exists.
 * 2 ----> PHP_SESSION_ACTIVE if sessions are enabled, and one exists.
 */

class Session
{
    public static function init()
    {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            if (session_id() == '') {
                session_start();
            }
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    public static function checkSession()
    {
        self::init();
        if (self::get("adminLogin") == false) {
            self::destroy();
            header("Location:login.php");
        }
    }

    public static function checkLogin()
    {
        self::init();
        if (self::get("adminLogin")) {
            header("Location:index.php");
        }
    }

    public static function destroy()
    {
        session_destroy();
        header("Location:login.php");
    }
}
