<?php

class Route
{
    public static $parentRoute='';

    public static $hasParent='no';

    public  function get($routeName='',$controllerName)
    {
        $uri=System::getUri();
        
        $varObject = '';



        // if(!isset($controllerName[1]))
        // {
        //     // Alert::make('Page not found');

        //     return false;
        // }




        $subFunc='index';


        if(isset($routeName[1]))
        {

            if(!stristr('\/', $routeName))
            {
                $routeName=str_replace('/', '\/', $routeName);               
            }

            if(isset($uri) && !preg_match('/'.$routeName.'/i', $uri))
            {
                return false;
            }
  
        }

        if(isset($uri) && preg_match('/(.*?)\@(\w+)/i', $controllerName,$matches))
        {
            $controllerName=$matches[1];

            $subFunc=$matches[2];
        }

        if (is_object($controllerName)) {

            (object)$varObject = $controllerName;

            $controllerName = '';

            $varObject();

        }          
        else
        {
            Controller::load($controllerName,$subFunc);
        }
        
        die();

    }
}

?>