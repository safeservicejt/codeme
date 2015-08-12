<?php

class View
{
    public static $loadPath = '';

    public static $hasCache='no';

    public function onCache()
    {
        self::$hasCache='yes';
    }

    public function offCache()
    {
        self::$hasCache='no';
    }

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

        if(!$loadCache=self::loadCache($path))
        {
            $total_data = count($viewData);

            if ($total_data > 0) extract($viewData);

            extract(System::$listVar['global']);

            if(isset(System::$listVar[$viewName]))
            {
               extract(System::$listVar[$viewName]); 
            }

            include($path);

            self::saveCache($path);            
        }
        else
        {
            echo $loadCache;
        }
    }

    public function loadCache($path)
    {
        if(self::$hasCache=='yes')
        {
            $md5Data=md5($path);  

            if($loadCache=Cache::loadKey($md5Data,-1))
            {
                return $loadCache;
            }
        }

        return false;        
    }

    public function saveCache($path)
    {
        if(self::$hasCache=='yes')
        {
            $viewsData = ob_get_contents();

            ob_end_clean();      
            
            $md5Data=md5($path);  

            Cache::saveKey($md5Data,$viewsData);
        }
    }

    public function load($viewName = '', $viewData = array())
    {
        self::make($viewName, $viewData);
    }


}

?>