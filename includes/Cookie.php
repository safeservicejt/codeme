<?php


class Cookie
{
    public function get($cookieName = '', $defaultVal=false)
    {
        $cookie = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : $defaultVal;

        return $cookie;
    }
    public function has($cookieName = '')
    {
        $cookie = isset($_COOKIE[$cookieName]) ? true : false;

        return $cookie;
    }

    public function make($cookieName = '', $cookieValue = '', $mins = 0)
    {
        if ($mins == 0) $mins=1;

        $mins = time() + ((int)$mins * 60);

        $urls=parse_url(ROOT_URL);

        setcookie($cookieName, $cookieValue, $mins,'/',$urls['host']);
    }



    public function destroy($cookieName = '')
    {
        $urls=parse_url(ROOT_URL);

        setcookie($cookieName, '', 1,'/',$urls['host']);
    }
}


?>