<?php

define("TXTCACHES", ROOT_PATH.'uploads/txtCaches/');

class txtCache
{

    public function make($txtDB = array(), $ipAdd = '')
    {

        $ipAdd = ($ipAdd == '') ? $_SERVER['REMOTE_ADDR'] : $ipAdd;

        $ipPath = TXTCACHES . $ipAdd . '.txt';

        $post = array('data' => $txtDB);

        $repost = json_encode($post);

        $fp = fopen($ipPath, 'w');

        fwrite($fp, $repost);

        fclose($fp);
    }

    public function push($keyName = '', $keyValue = '', $ipAdd = '')
    {
        $ipAdd = ($ipAdd == '') ? $_SERVER['REMOTE_ADDR'] : $ipAdd;

        $ipPath = TXTCACHES . $ipAdd . '.txt';

        if (!file_exists($ipPath)) {
            return false;
        }

        $cacheData = file_get_contents($ipPath);

        $dataDB = json_decode($cacheData, true);

        $dataDB['data'][$keyName] = $keyValue;

        $repost = json_encode($dataDB);

        $fp = fopen($ipPath, 'w');

        fwrite($fp, $repost);

        fclose($fp);

    }

    public function get($keyName = '', $ipAdd = '')
    {
        $ipAdd = ($ipAdd == '') ? $_SERVER['REMOTE_ADDR'] : $ipAdd;

        $ipPath = TXTCACHES . $ipAdd . '.txt';

        if (!file_exists($ipPath)) {
            return false;
        }

        $cacheData = file_get_contents($ipPath);

        $dataDB = json_decode($cacheData, true);

        if ($keyName == '') return $dataDB['data'];

        return $dataDB['data'][$keyName];


    }

    public function edit($keyName = '', $keyValue = '', $ipAdd = '')
    {
        $ipAdd = ($ipAdd == '') ? $_SERVER['REMOTE_ADDR'] : $ipAdd;

        $ipPath = TXTCACHES . $ipAdd . '.txt';

        if (!file_exists($ipPath)) {
            return false;
        }

        $cacheData = file_get_contents($ipPath);

        $dataDB = json_decode($cacheData, true);

        $dataDB['data'][$keyName] = $keyValue;

        $repost = json_encode($dataDB);

        $fp = fopen($ipPath, 'w');

        fwrite($fp, $repost);

        fclose($fp);

    }


    public function delete($keyName = '', $ipAdd = '')
    {
        $ipAdd = ($ipAdd == '') ? $_SERVER['REMOTE_ADDR'] : $ipAdd;

        $ipPath = TXTCACHES . $ipAdd . '.txt';

        if (!file_exists($ipPath)) {
            return false;
        }

        $cacheData = file_get_contents($ipPath);

        $dataDB = json_decode($cacheData, true);

        unset($dataDB['data'][$keyName]);

        $repost = json_encode($dataDB);

        $fp = fopen($ipPath, 'w');

        fwrite($fp, $repost);

        fclose($fp);

    }


    public function clean($ipAdd = '')
    {
        $ipAdd = ($ipAdd == '') ? $_SERVER['REMOTE_ADDR'] : $ipAdd;

        $ipPath = TXTCACHES . $ipAdd . '.txt';

        if (!file_exists($ipPath)) {
            return false;
        }

        unlink($ipPath);

    }

    public function cleanDB($ttl = 900)
    {
        if ($handle = opendir(TXTCACHES)) {
            while (false !== ($file = readdir($handle))) {

                if ($file != '.' && $file != '..') {
                    $createTime = filectime(TXTCACHES . $file);

                    $modTime = filemtime(TXTCACHES . $file);


                    $subTime = $modTime - $createTime;

                    if ($subTime >= $ttl) {
                        unlink(TXTCACHES . $file);
                    }

                }

            }
            closedir($handle);
        }
    }


}

?>