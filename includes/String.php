<?php

class String
{
    public function stripUnicode($str)
    {
        if (!$str) return false;
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ|Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        return $str;
    }
    public function makeFriendlyUrl($inputStr='',$type='-')
    {
        if(!isset($inputStr[2]))
        {
            return $inputStr;
        }

        // $retext=preg_replace('/\U/i', '', $inputStr);

        $retext=String::stripUnicode($inputStr);

        preg_match_all('/([a-zA-Z0-9]+)/i', $retext,$matches);
    
        $retext=implode($type, $matches[1]);
        
        return $retext;
    }    
    public function action($funcName='',$inputData=array())
    {
        if(!function_exists($funcName))
        {
            return false;
        }

        $inputData=array_map($funcName, $inputData);

        return $inputData;
    }
    
    public function encrypt($pure_string) {
        
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, ENCRYPT_SECRET_KEY, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);

    $encrypted_string=base64_encode($encrypted_string);

    return $encrypted_string;   
    }

    public function decrypt($encrypted_string) {

    $encrypted_string=base64_decode($encrypted_string);

    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, ENCRYPT_SECRET_KEY, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;

    }


    public function encode($str)
    {
        $str=addslashes($str);

        return $str;
    }

    public function decode($text)
    {
        $text=stripslashes($text);

        return $text;
    } 
       
    public function trimLines($Str = '')
    {
        $parseStr = explode("\r\n", $Str);

        $totalLines = count($parseStr);

        $strResult = '';

        for ($i = 0; $i < $totalLines; $i++) {
            if ($parseStr[$i] != '')
                $strResult .= trim($parseStr[$i]) . "\r\n";
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

    public function utf8ToLower($inputData)
    {
        $inputData=mb_convert_case(trim($inputData), MB_CASE_LOWER, "UTF-8");
    }
    
    public function utf8ToUpper($inputData)
    {
        $inputData=mb_convert_case(trim($inputData), MB_CASE_UPPER, "UTF-8");
    }

    public function utf8ToTitle($inputData)
    {
        $inputData=mb_convert_case(trim($inputData), MB_CASE_TITLE, "UTF-8");
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
        $str = 'abcdefghijkl0123456789mnopqrstuvwxyzhijklmnopqrs0123456789tuvwxyzABCDEFGHIJKLM0123456789NOPQRSTUVWXYZ01234567ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $str = substr(str_shuffle($str), 0, $len);

        return $str;

    }

    public function moneyToText($number) {
 
        $hyphen      = ' ';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'âm ';
        $decimal     = ' phẩy ';
        $dictionary  = array(
        0                   => 'Không',
        1                   => 'Một',
        2                   => 'Hai',
        3                   => 'Ba',
        4                   => 'Bốn',
        5                   => 'Năm',
        6                   => 'Sáu',
        7                   => 'Bảy',
        8                   => 'Tám',
        9                   => 'Chín',
        10                  => 'Mười',
        11                  => 'Mười một',
        12                  => 'Mười hai',
        13                  => 'Mười ba',
        14                  => 'Mười bốn',
        15                  => 'Mười năm',
        16                  => 'Mười sáu',
        17                  => 'Mười bảy',
        18                  => 'Mười tám',
        19                  => 'Mười chín',
        20                  => 'Hai mươi',
        30                  => 'Ba mươi',
        40                  => 'Bốn mươi',
        50                  => 'Năm mươi',
        60                  => 'Sáu mươi',
        70                  => 'Bảy mươi',
        80                  => 'Tám mươi',
        90                  => 'Chín mươi',
        100                 => 'trăm',
        1000                => 'ngàn',
        1000000             => 'triệu',
        1000000000          => 'tỷ',
        1000000000000       => 'nghìn tỷ',
        1000000000000000    => 'ngàn triệu triệu',
        1000000000000000000 => 'tỷ tỷ'
        );
         
        if (!is_numeric($number)) {
        return false;
        }
         
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
        'Only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
        E_USER_WARNING
        );
        return false;
        }
         
        if ($number < 0) {
        return $negative . self::moneyToText(abs($number));
        }
         
        $string = $fraction = null;
         
        if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
        }
         
        switch (true) {
        case $number < 21:
        $string = $dictionary[$number];
        break;
        case $number < 100:
        $tens   = ((int) ($number / 10)) * 10;
        $units  = $number % 10;
        $string = $dictionary[$tens];
        if ($units) {
        $string .= $hyphen . $dictionary[$units];
        }
        break;
        case $number < 1000:
        $hundreds  = $number / 100;
        $remainder = $number % 100;
        $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
        if ($remainder) {
        $string .= $conjunction . self::moneyToText($remainder);
        }
        break;
        default:
        $baseUnit = pow(1000, floor(log($number, 1000)));
        $numBaseUnits = (int) ($number / $baseUnit);
        $remainder = $number % $baseUnit;
        $string = self::moneyToText($numBaseUnits) . ' ' . $dictionary[$baseUnit];
        if ($remainder) {
        $string .= $remainder < 100 ? $conjunction : $separator;
        $string .= self::moneyToText($remainder);
        }
        break;
        }
         
        if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
        $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
        }

        $string=ucfirst(mb_convert_case(trim($string), MB_CASE_LOWER, "UTF-8"));

        $string=preg_replace('/(.*?) một$/i', '$1 mốt', $string);
         
        return $string;
    }

}


?>