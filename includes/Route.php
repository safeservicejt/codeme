<?php

class Route
{
    public static $parentRoute='';

    public static $hasParent='no';

    public function get($routeName='',$controllerName)
    {
        $varObject = '';

        if(!isset($controllerName[1]))
        {
            // Alert::make('Page not found');

            return false;
        }


        if (is_object($controllerName)) {

            (object)$varObject = $controllerName;

            $controllerName = '';

            die();
        }  

        $subFunc='index';


        if(isset($routeName[1]))
        {

            if(!stristr('\/', $routeName))
            {
                $routeName=str_replace('/', '\/', $routeName);               
            }

            if(isset($_GET['load']) && !preg_match('/'.$routeName.'/i', $_GET['load']))
            {
                // Alert::make('Page not found');

                return false;
            }
  
        }

        if(isset($_GET['load']) && preg_match('/(.*?)\@(\w+)/i', $controllerName,$matches))
        {
            $controllerName=$matches[1];

            $subFunc=$matches[2];
        }

        Controller::load($controllerName,$subFunc);

        die();

    }
}

?>