<?php

class String
{

    public function trimLines($Str = '')
    {
        $parseStr = explode("\r\n", $Str);

        $totalLines = count($parseStr);

        $strResult = '';

        for ($i = 0; $i < $totalLines; $i++) {
            if ($parseStr[$i] != '')
                $strResult .= $parseStr[$i] . "\r\n";
        }

        return $strResult;

    }

    public function clearSpace($Str = '')
    {
        if (isset($Str[1])) {
            preg_match_all('/([\w\S]+)/i', $Str, $matches);

            $strResult = implode(' ', $matches[1]);

            return $strResult;
        }

        return $Str;

    }

    public function Split($Char = '', $Str = '')
    {
        $strResult = explode($Char, $Str);

        return $strResult;
    }

    public function randNumber($len = 10)
    {
        $str = '012010123456789234560123450123456789234560123456789789345012345601234567892345601234567897893450123456678978934501234567896789';

        $str = substr(str_shuffle($str), 0, $len);

        return $str;

    }

    public function randAlpha($len = 10)
    {
        $str = 'abcdefghijklmnopfghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUqrstufghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $str = substr(str_shuffle($str), 0, $len);

        return $str;

    }

    public function randText($len = 10)
    {
        $str = 'abcdefghjk12345zhjk56789mnpqrzABCDEFGHIJKMNOPQRSTUstuvwxy6789mnpqrstuvwxyzhjk56789mnpqrzABCDEFGHIJKMNOPQRSTUstuvwxyzhjkmrstyz';

        $str = substr(str_shuffle($str), 0, $len);

        return $str;

    }


}


?>