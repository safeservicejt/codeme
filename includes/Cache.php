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

        $load = isset($_GET['load']) ? $_GET['load'] : 'default_codeme';

        $url = trim($load);

        $cachePath = CACHES_PATH . md5($url) . '.cache';

        if (file_exists($cachePath)) {

            $cacheExpires = time() - filemtime($cachePath);

            if ($cacheExpires <= (int)self::$cacheLiveTime) {
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

    // Default timeLive=1 day
    public function saveKey($keyName,$keyData='')
    {
        $filePath=CACHES_PATH.$keyName.'.cache';

        $fp=fopen($filePath,'w');

        fwrite($fp,$keyData);

        fclose($fp);
    }

    public function loadKey($keyName,$timeLive=86400)
    {
        $filePath=CACHES_PATH.$keyName.'.cache';

        if(!file_exists($filePath))return false;

        $cacheExpires = time() - filemtime($filePath);

        if ((int)$timeLive == -1 || $cacheExpires <= (int)$timeLive) {
            $cacheData = file_get_contents($filePath);

            return $cacheData;
        }

        return false;        
    }
    public function removeKey($keyName)
    {
        $filePath=CACHES_PATH.$keyName.'.cache';

        if(!file_exists($filePath))return true;

        unlink($filePath);

        return true;        
    }

    public function saveCache()
    {

        if (self::$cacheStatus == 'enable') {

            $load = isset($_GET['load']) ? $_GET['load'] : 'default_codeme';

            $url = trim($load);

            $savePath = CACHES_PATH . md5($url) . '.cache';

            $viewsData = ob_get_contents();

            ob_end_clean();

            File::create($savePath, $viewsData);

            echo $viewsData;
        }

    }
}

?>