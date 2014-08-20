<?php

class Controller
{
    public function load($controlName = '', $funcName = 'index')
    {

        $funcOfController = '';

        if (preg_match('/(\w+)\@(\w+)/i', $controlName, $matchesName)) {
            $controlName = $matchesName[1];

            $funcOfController = $matchesName[2];

            $funcName = $funcOfController;
        }

        $path = CONTROLLERS_PATH . $controlName . '.php';

        if (!file_exists($path)) Alert::make('Controller <b>'.$controlName.'</b> not exists.');

        include($path);

        $load = new $controlName();

        if (!isset($funcName[0])) $funcName = 'index';



        if (!method_exists($load, $funcName)) Alert::make('Function <b>'.$funcName.'</b> not exists inside controller <b>'.$controlName.'</b> .');

        $load->$funcName();

    }

    public function funcExist($controllerName='',$funcName='')
    {

    }


}

?>