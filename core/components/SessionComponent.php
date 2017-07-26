<?php
/**
 * Created by PhpStorm.
 * User: cristiandean
 * Date: 21/07/17
 * Time: 09:55
 *
 * Componente de gerenciamento de sessão
 */

namespace components;


class SessionComponent
{

    private static $session;

    function __construct()
    {
    }


    /**
     * @param mixed $session
     */
    public function set($key, $value)
    {
        self::$session[$key] = serialize($value);
        $_SESSION[$key] = serialize($value);
    }

    public static function destroy()
    {
        session_destroy();
    }

    /**
     * @return mixed
     */
    public static function read($index = null)
    {
        if ($index == null)
            return self::getSession();
        return (accessArray(self::getSession(), $index));
    }

    private static function getSession()
    {
        if (self::$session == null)
            self::$session = $_SESSION;
        return self::$session;
    }

}