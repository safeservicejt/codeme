<?php

class Cache
{

    private static $cacheStatus = 'disabled';

    private static $cacheLiveTime = 360;

    public static $cachePath = '';

    public function setPath($path)
    {
        $path=!isset($path[2])?CACHES_PATH:$path;

        self::$cachePath=$path;
    }

    public function resetPath()
    {
        self::$cachePath=CACHES_PATH;
    }
    
    public function getPath()
    {
        $path=!isset(self::$cachePath[2])?CACHES_PATH:self::$cachePath;

        self::$cachePath=$path;

        return $path;
    }
  
    public function enable($liveTime = 360)
    {
        self::$cacheStatus = 'enable';

        self::$cacheLiveTime = $liveTime;

        self::loadCache();
    }

    public function savePage($extension='.template')
    {
        $keyName=isset($_GET['load'])?trim($_GET['load']):'defaultHome';

        $savePath=ROOT_PATH.'application/caches/templates/';

        self::setPath($savePath);

        $keyData=ob_get_contents();

        $keyName=md5($keyName);

        $keyData=gzcompress($keyData,5);

        self::saveKey($keyName,serialize($keyData),$extension);

        self::resetPath();
    }

    public function loadPage($liveTime=86400,$extension='.template')
    {
        $keyName=isset($_GET['load'])?trim($_GET['load']):'defaultHome';

        $keyName=md5($keyName);

        $savePath=ROOT_PATH.'application/caches/templates/';

        self::setPath($savePath);        

        if(!$loadData=self::loadKey($keyName,$liveTime,$extension))
        {
            return false;
        }

        $loadData=unserialize($loadData);

        $loadData=gzuncompress($loadData);  

        echo $loadData;

        exit(0);
    }

    public function loadCache()
    {

        $load = isset($_GET['load']) ? $_GET['load'] : 'default_codeme';

        $url = trim($load);

        // $cachePath = CACHES_PATH . md5($url) . '.cache';
        $cachePath = self::getPath() . md5($url) . '.cache';

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
    public function saveKey($keyName,$keyData='',$extension='.cache')
    {
        // $filePath=CACHES_PATH.$keyName.'.cache';
        $filePath=self::getPath().$keyName.$extension;

        $fp=fopen($filePath,'w');

        fwrite($fp,$keyData);

        fclose($fp);
    }

    public function loadKey($keyName,$timeLive=86400,$extension='.cache')
    {
        // $filePath=CACHES_PATH.$keyName.'.cache';
        $filePath=self::getPath().$keyName.$extension;

        // die($filePath);

        if(!file_exists($filePath))return false;

        $cacheExpires = time() - filemtime($filePath);

        if ((int)$timeLive == -1 || $cacheExpires <= (int)$timeLive) {
            $cacheData = file_get_contents($filePath);

            return $cacheData;
        }

        return false;        
    }
    public function removeKey($keyName,$extension='.cache')
    {
        // $filePath=CACHES_PATH.$keyName.'.cache';
        $filePath=self::getPath().$keyName.$extension;

        if(!file_exists($filePath))return true;

        unlink($filePath);

        return true;        
    }

    public function saveCache()
    {

        if (self::$cacheStatus == 'enable') {

            $load = isset($_GET['load']) ? $_GET['load'] : 'default_codeme';

            $url = trim($load);

            // $savePath = CACHES_PATH . md5($url) . '.cache';
            $savePath = self::getPath() . md5($url) . '.cache';

            $viewsData = ob_get_contents();

            ob_end_clean();

            File::create($savePath, $viewsData);

            echo $viewsData;
        }

    }
}

?>