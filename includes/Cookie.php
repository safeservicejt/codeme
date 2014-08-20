<?php


class Cookie
{
    public function get($cookieName = '')
    {
        $cookie = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : false;

        return $cookie;
    }

    public function make($cookieName = '', $cookieValue = '', $mins = 0)
    {
        if ($mins == 0) $mins = time() + ((int)$mins * 60);

        setcookie($cookieName, $cookieValue, $mins);
    }
}


?>