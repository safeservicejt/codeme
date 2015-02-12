<?php

class Session
{

    public function get($sessionName = '',$defaultValue=false)
    {
        $resultData = $defaultValue;
        
        if (!preg_match('/^(\w+)\.(\w+)$/i', $sessionName, $matches)) {
            $resultData = isset($_SESSION["$sessionName"]) ? $_SESSION["$sessionName"] : $defaultValue;
  
        } else {

            $sessionMain = $matches[1];

            $sessionChild = $matches[2];

            $resultData = isset($_SESSION["$sessionMain"]["$sessionChild"]) ? $_SESSION["$sessionMain"]["$sessionChild"] : $defaultValue;

        }
         
        return $resultData;

    }

    public function has($sessionName='')
    {

        if (!preg_match('/(\w+)\.(\w+)/i', $sessionName, $matches)) {
            $session = isset($_SESSION[$sessionName]) ? true : false;

            return $session;
        } else {

            $sessionMain = $matches[1];

            $sessionChild = $matches[2];

            if(!isset($_SESSION[$sessionMain][$sessionChild]))
            {
                return false;
            }

        }

        return true;
    }

    public function make($sessionName = '', $sessionValue = '')
    {
            $_SESSION[$sessionName] = $sessionValue;
    }

    public function forget($sessionName = '')
    {
        if (!preg_match('/(\w+)\.(\w+)/i', $sessionName, $matches)) {
            unset($_SESSION[$sessionName]);
        } else {

            $sessionMain = $matches[1];

            $sessionChild = $matches[2];

            unset($_SESSION[$sessionMain][$sessionChild]);

        }
    }

    public function remove($sessionName = '')
    {
        self::forget($sessionName);
    }

    public function flush()
    {
        session_unset();
    }

    public function push($sessionName = '', $sessionValue = '')
    {
        preg_match('/(\w+)\.(\w+)/i', $sessionName, $matches);

        $sessionMain = $matches[1];

        $sessionChild = $matches[2];


        $_SESSION[$sessionMain][$sessionChild] = $sessionValue;
    }

    public function put($sessionName = '', $sessionValue = '')
    {
        self::make($sessionName, $sessionValue);
    }


}



?>