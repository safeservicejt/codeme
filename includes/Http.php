<?php

class Http
{
    public function sendPostTo($url = '', $post = array(), $cookiepath = '/.cookie_tmp.txt', $is_follow = 'no')
    {
        ob_flush();
        $ch = curl_init();
//    curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        if ($is_follow == 'yes') curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
//    curl_setopt($ch, CURLOPT_USERAGENT, " Google Mozilla/5.0 (compatible; Googlebot/2.1;)");
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiepath);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $data = curl_exec($ch);
        ob_end_flush();
        return $data;
    }

    public function sendGetTo($url = '', $post = array(), $cookiepath = '/.cookie_tmp.txt')
    {
        ob_flush();
        $ch = curl_init();
//    curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_USERAGENT, " Google Mozilla/5.0 (compatible; Googlebot/2.1;)");
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiepath);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiepath);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 500);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $data = curl_exec($ch);
        ob_end_flush();
        return $data;
    }

    public function getDataUrl($url, $follow = 'yes')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, " Google Mozilla/5.0 (compatible; Googlebot/2.1;)");
        if ($follow == 'yes') curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com/bot.html");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result = curl_exec($ch);
        return $result;
    }

    public function copyDataUrl($source, $desc)
    {
        $descfile = fopen($desc, "w");

        $handle = fopen($source, "rb");
        while (!feof($handle)) {
            $contents = fread($handle, 1024);
            fwrite($descfile, $contents);
        }
        fclose($handle);
        fclose($descfile);

        return true;
    }
}


?>