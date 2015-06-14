<?php

class View
{
    public static $loadPath = '';

    public function setPath($path)
    {
        $path=!isset($path[2])?VIEWS_PATH:$path;

        self::$loadPath=$path;
    }
    
    public function resetPath()
    {
        self::$loadPath=VIEWS_PATH;
    }

    public function getPath()
    {
        $path=!isset(self::$loadPath[2])?VIEWS_PATH:self::$loadPath;

        self::$loadPath=$path;

        return $path;
    }
    
    public function makeWithPath($viewName = '', $viewData = array(),$path)
    {
        self::setPath($path);

        self::make($viewName,$viewData);

        self::resetPath();
    }

    

    public function make($viewName = '', $viewData = array())
    {
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

        // $path = VIEWS_PATH . $viewName . '.php';
        $path = self::getPath() . $viewName . '.php';

        if (!file_exists($path)) {

            Log::warning("View $viewName not exists!");
        }

        $total_data = count($viewData);

        if ($total_data > 0) extract($viewData);

        include($path);
    }

    public function load($viewName = '', $viewData = array())
    {
        self::make($viewName, $viewData);
    }


}

?>