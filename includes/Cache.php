<?php

class Cache
{

    private static $cacheStatus = 'disabled';
    private static $cacheLiveTime = 360;

    public function enable($liveTime = 360)
    {
        self::$cacheStatus = 'enable';

        self::$cacheLiveTime = $liveTime;

        self::loadCache();
    }

    public function loadCache()
    {

        $url = trim($_GET['load']);

        $cachePath = CACHES_PATH . md5($url) . '.cache';

        if (file_exists($cachePath)) {

            $cacheExpires=time() - filemtime($cachePath);

            if($cacheExpires <= (int)self::$cacheLiveTime)
            {
                $cacheData = file_get_contents($cachePath);

                echo $cacheData;

                die();
            }

        }

//        if (self::$cacheStatus == 'enable') {
//            $url = trim($_GET['load']);
//
//            $cachePath = CACHES_PATH . md5($url) . '.cache';
//
//            if (file_exists($cachePath)) {
//
//                $cacheData = file_get_contents($cachePath);
//
//                echo $cacheData;
//
//            }
//
//        }
    }

    public function saveCache()
    {
        if (self::$cacheStatus == 'enable') {
            $url = trim($_GET['load']);

            $savePath = CACHES_PATH . md5($url) . '.cache';

            $viewsData = ob_get_contents();

            ob_end_clean();

            File::create($savePath, $viewsData);

            echo $viewsData;
        }

    }
}

?>