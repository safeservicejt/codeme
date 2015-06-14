<?php

class Http
{
    public function get($inputData)
    {
        $inputData=strtolower($inputData);

        $inputData=($inputData=='refer')?'referer':$inputData;
        $inputData=($inputData=='ref')?'referer':$inputData;

        $inputData=($inputData=='ua')?'useragent':$inputData;

        $inputData=($inputData=='remoteadd')?'remoteip':$inputData;
       $inputData=($inputData=='ip')?'remoteip':$inputData;

        $inputData=($inputData=='authpassword')?'authpass':$inputData;



        $result='';

        switch ($inputData) {
            case 'referer':
                $result=$_SERVER['HTTP_REFERER'];
                break;
            case 'useragent':
                $result=$_SERVER['HTTP_USER_AGENT'];
                break;
            case 'host':
                $result=$_SERVER['HTTP_HOST'];
                break;
            case 'referer':
                $result=$_SERVER['HTTP_REFERER'];
                break;
            case 'remoteip':
                $result=$_SERVER['REMOTE_ADDR'];
                break;
            case 'remotehost':
                $result=$_SERVER['REMOTE_HOST'];
                break;
            case 'remoteport':
                $result=$_SERVER['REMOTE_PORT'];
                break;
            case 'remoteuser':
                $result=$_SERVER['REMOTE_USER'];
                break;
            case 'authuser':
                $result=$_SERVER['PHP_AUTH_USER'];
                break;
            case 'authpass':
                $result=$_SERVER['PHP_AUTH_PW'];
                break;
            case 'authtype':
                $result=$_SERVER['AUTH_TYPE'];
                break;
            
        }

        return $result;
    }

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

    public function getDataUrl($url,$hasHeader='no', $follow = 'yes',$isGooglebot='yes')
    {
        $headers = array();
        // $headers[] = 'X-Apple-Tz: 0';
        // $headers[] = 'X-Apple-Store-Front: 143444,12';
        // $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        // $headers[] = 'Accept-Encoding: gzip, deflate';
        // $headers[] = 'Accept-Language: en-US,en;q=0.5';
        $headers[] = 'Cache-Control: max-age=0';
        $headers[] = 'Content-Type: text/html';
         $headers[] = 'Connection: keep-alive';
         $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
         $headers[] = 'Accept-Encoding: gzip, deflate, sdch';

        // $headers[] = 'Host: www.example.com';
        // $headers[] = 'Referer: http://www.example.com/index.php'; //Your referrer address
        // $headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';
        // $headers[] = 'X-MicrosoftAjax: Delta=true';

        $ch = curl_init();
        if ($follow == 'yes') curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        if($hasHeader=='yes')
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result = curl_exec($ch);

        // $result=gzuncompress($result);

        if($hasHeader=='yes')
        $result=Compress::gzdecode($result);

         // File::create(ROOT_PATH.'accc.txt',$result);

        return $result;
    }
    public function getDataUrlByGoogleBot($url,$hasHeader='yes', $follow = 'yes')
    {
        $headers = array();
        // $headers[] = 'X-Apple-Tz: 0';
        // $headers[] = 'X-Apple-Store-Front: 143444,12';
        // $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        // $headers[] = 'Accept-Encoding: gzip, deflate';
        // $headers[] = 'Accept-Language: en-US,en;q=0.5';
        $headers[] = 'Cache-Control: max-age=0';
        $headers[] = 'Content-Type: text/html';
         $headers[] = 'Connection: keep-alive';
         $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
         $headers[] = 'Accept-Encoding: gzip, deflate, sdch';

        // $headers[] = 'Host: www.example.com';
        // $headers[] = 'Referer: http://www.example.com/index.php'; //Your referrer address
        // $headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';
        // $headers[] = 'X-MicrosoftAjax: Delta=true';

        $ch = curl_init();
        if ($follow == 'yes') curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        if($hasHeader=='yes')        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, " Google Mozilla/5.0 (compatible; Googlebot/2.1;)");
        curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com/bot.html");
        // curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result = curl_exec($ch);

        // $result=gzuncompress($result);

        if($hasHeader=='yes')
        $result=Compress::gzdecode($result);

         // File::create(ROOT_PATH.'accc.txt',$result);

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