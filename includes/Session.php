<?php



class Session
{


    function __construct()
    {
    }

    public function get($sessionName = '')
    {
        $session = false;
        if (session_id() != null && isset($_SESSION[$sessionName])) {

            if (!preg_match('/(\w+)\.(\w+)/i', $sessionName, $matches)) {
                $session = isset($_SESSION[$sessionName]) ? $_SESSION[$sessionName] : '';
            } else {

                $sessionMain = $matches[1];

                $sessionChild = $matches[2];

                $session = $_SESSION[$sessionMain][$sessionChild];

            }

        }

        return $session;

    }

    public function has($sessionName='')
    {
        if(!isset($_SESSION[$sessionName]))
        {
            return false;
        }

        if (!preg_match('/(\w+)\.(\w+)/i', $sessionName, $matches)) {
            $session = isset($_SESSION[$sessionName]) ? $_SESSION[$sessionName] : '';
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
        if (session_id() != null) {
            $_SESSION[$sessionName] = $sessionValue;
        }
    }

    public function forget($sessionName = '')
    {
        if (session_id() != null) {

            if (!preg_match('/(\w+)\.(\w+)/i', $sessionName, $matches)) {
                unset($_SESSION[$sessionName]);
            } else {

                $sessionMain = $matches[1];

                $sessionChild = $matches[2];

                unset($_SESSION[$sessionMain][$sessionChild]);

            }

        }
    }

    public function remove($sessionName = '')
    {
        self::forget($sessionName);
    }

    public function flush()
    {
        if (session_id() != null) {
            session_unset();
        }
    }

    public function push($sessionName = '', $sessionValue = '')
    {
        if (session_id() != null) {

            preg_match('/(\w+)\.(\w+)/i', $sessionName, $matches);

            $sessionMain = $matches[1];

            $sessionChild = $matches[2];


            $_SESSION[$sessionMain][$sessionChild] = $sessionValue;
        }
    }

    public function put($sessionName = '', $sessionValue = '')
    {
        self::make($sessionName, $sessionValue);
    }


}



?>