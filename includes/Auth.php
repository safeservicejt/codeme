<?php

class Auth
{

    private static $authUser = '';

    private static $authPassword = '';

    public function make($title = 'Login', $errorMessage = 'You must enter a valid login ID and password to access this resource')
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="' . $title . '"');
            header('HTTP/1.0 401 Unauthorized');
            echo $errorMessage . "\n";
            exit;
        }

        self::$authUser = $_SERVER['PHP_AUTH_USER'];
        self::$authPassword = $_SERVER['PHP_AUTH_PW'];

    }

    public function getUsername()
    {
        return self::$authUser;
    }

    public function getPassword()
    {
        return self::$authPassword;
    }


}

?>