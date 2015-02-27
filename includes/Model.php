<?php

class Model
{
    public static $loadPath = '';

    
    public function setPath($path)
    {
        $path=!isset($path[2])?MODELS_PATH:$path;

        self::$loadPath=$path;
    }

    public function getPath()
    {
        $path=!isset(self::$loadPath[2])?MODELS_PATH:self::$loadPath;

        self::$loadPath=$path;

        return $path;
    }
    

    public function load($modelName = '')
    {
        // $path = MODELS_PATH . $modelName . '.php';
        $path = self::getPath() . $modelName . '.php';

        if (!file_exists($path)) Alert::make('Model <b>' . $modelName . '</b> not exists.');

        include($path);
    }


}

?>