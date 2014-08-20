<?php


function split_content($str = '', $len = 500)
{
    if (isset($str[500])) {

//        $bbtags=array(
//          '<code>'=>'','</code>'=>''
//        );
//
//        $str = str_ireplace(array_keys($bbtags), array_values($bbtags), $str);

        $str = substr($str, 0, $len);
    }

    return $str;
}


function strtofriendly($str='')
{
    preg_match_all('/(\w+)/i',$str,$matches);

    $total=count($matches[1]);

    $friendly=implode('_',$matches[1]);

    return $friendly;

}

function Xoadaucach($str)
{

    if (stristr($str, "  ")) {
        while (stristr($str, "  ")) {
            $str = str_replace("  ", " ", $str);
        }

    }

    return $str;


}

function strtorand($method='number',$len = 10)
{
    $str='01201012345678923456012345678978934501234567896789';

    switch($method)
    {
        case 'number':
            $str='012010123456789234560123450123456789234560123456789789345012345601234567892345601234567897893450123456678978934501234567896789';
            break;

        case 'string':
            $str='abcdefghijklmnopfghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUqrstufghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 'text':
            $str='abcdefghijklmnopqrstuvwxyzhijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            break;

    }
    $str = substr( str_shuffle( $str ) , 0 , $len );

    return $str;
}


?>