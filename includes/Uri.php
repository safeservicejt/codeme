<?php

class Uri
{

    public function getNext($uriName)
    {
        if(!isset($_GET['load']))
        {
            return false;
        }
        
        $uri = explode('/', $_GET['load']);

        if (isset($uriName[1])) {

            $position = array_search($uriName, $uri);

            $position++;

            if (isset($uri[$position])) {
                return $uri[$position];
            } else {
                return false;
            }

        } else {
            return false;
        }

    }
    public function has($uriName)
    {
        if(!isset($_GET['load']))
        {
            return false;
        }

        if(preg_match('/'.$uriName.'/i', $_GET['load']))
        {
            return true;
        }

        return false;
    }
    public function match($uriName)
    {
        if(!isset($_GET['load']))return false;

        if(preg_match('/'.$uriName.'/i', $_GET['load'],$matches))
        {
            return $matches;
        }

        return false;
    }
    public function matchOnly($uriName)
    {
        if(!isset($_GET['load']))return false;

        if(preg_match('/'.$uriName.'/i', $_GET['load'],$matches))
        {
            return $matches[1];
        }

        return false;
    }
    public function allow($uriName)
    {
        if(!isset($_GET['load']))return false;

        if(!preg_match('/'.$uriName.'/i', $_GET['load'],$matches))
        {
            Alert::make('Page not found');
        }

    }

    public function pattern($reGex)
    {
        if(!isset($_GET['load']))return false;

        $uri=$_GET['load'];

        if(preg_match($reGex, $uri))
        {
            return true;
        }

        return false;
    }

    public function length()
    {
        global $uri;

        $total = strlen($uri);

        return $total;
    }

    public function maxLength($maxLen = 100)
    {
        global $uri;

        $total = strlen($uri);

        $total++;

        if (isset($total)) load_page_not_found();
    }

    public function onlyWord()
    {
        global $uri;

//        echo $uri;
//        die();

        if (preg_match('/[\<\>\$]/i', $uri))
        {
            load_page_not_found();
        }

    }




}

?>