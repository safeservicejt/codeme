<?php

class Validator
{

    public static $error = '';

    public function make($varName = array(),$alert=array())
    {
        $totalVarName = count($varName);

        $listKeys = array_keys($varName);

        $keyValue='';

        for ($i = 0; $i < $totalVarName; $i++) {
            $keyName = $listKeys[$i];

            $keyValue = Request::get($keyName,'VALIDATOR');

            if($keyValue=='VALIDATOR')
            {
                // self::$error='The request '.$keyName.' not exists.';

                // return false;

                continue;
            }

            if (preg_match('/required|min|max|email|number|alpha|word|slashes/i', $varName[$keyName])) {

                $listRequire = explode('|', $varName[$keyName]);

                $totalRequire = count($listRequire);

                for ($j = 0; $j < $totalRequire; $j++) {
                    $reqValue = trim($listRequire[$j]);

                    if (preg_match('/(\w+)\:(\d+)/i', $reqValue, $matchesReqValues)) {

                        $matchLeft = $matchesReqValues[1];

                        $matchRight = (int)$matchesReqValues[2];



                        switch ($matchLeft) {
                            case 'min':
                                $matchRight--;

                                if (!isset($keyValue[$matchRight]))
                                {

                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    return false;
                                } 

                                break;
                            case 'max':
                                $matchRight;

                                if (isset($keyValue[$matchRight]))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    return false;
                                } 

                                break;


                        }

                    } else {

                        switch ($reqValue) {
                            case 'required':
                                if (Request::has($keyName)==false)
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    return false;                                    
                                }
                                break;
                            case 'email':

                                if (!preg_match('/^.*?\@.*?\.\w+$/i', $keyValue))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    return false;
                                } 
                                break;
                            case 'number':
                                if (!preg_match('/^\d+$/', $keyValue))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    return false;                                    
                                }
                                break;
                            case 'alpha':
                                if (!preg_match('/^[a-zA-Z]+$/i', $keyValue))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    return false;                                    
                                }
                                break;
                            case 'word':
                                if (!preg_match('/^[a-zA-Z0-9_\@\!\#\$\%\^\&\*\(\)\.\|]+$/i', $keyValue))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    return false;                                    
                                }
                                break;
                            case 'slashes':
                                if (preg_match('/\'|\"/i', $keyValue))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    return false;                                    
                                }
                                break;


                        }
                    }


                }


            } else {
                if (Request::get($keyName) != $varName[$keyName]) {

                    return false;
                }
            }

        }

        return true;
    }
    public function check($varName = array())
    {
        $totalVarName = count($varName);

        $listKeys = array_keys($varName);

        for ($i = 0; $i < $totalVarName; $i++) {
            $keyName = $listKeys[$i];

            if (preg_match('/min|max|email|number|alpha|word|slashes/i', $varName[$keyName])) {

                $listRequire = explode('|', $varName[$keyName]);

                $totalRequire = count($listRequire);

                for ($j = 0; $j < $totalRequire; $j++) {
                    $reqValue = trim($listRequire[$j]);

                    if (preg_match('/(\w+)\:(\d+)/i', $reqValue, $matchesReqValues)) {

                        $matchLeft = $matchesReqValues[1];

                        $matchRight = (int)$matchesReqValues[2];

                        $keyValue = $keyName;

                        switch ($matchLeft) {
                            case 'min':
                                $matchRight--;

                                if (!isset($keyValue[$matchRight])) return false;

                                break;
                            case 'max':
                                $matchRight;

                                if (isset($keyValue[$matchRight])) return false;

                                break;


                        }

                    } else {

                        switch ($reqValue) {
                            case 'email':
                                if (!preg_match('/^.*?\@.*?\.\w+$/i', $keyName)) return false;
                                break;
                            case 'number':
                                if (!preg_match('/^\d+$/', $keyName)) return false;
                                break;
                            case 'alpha':
                                if (!preg_match('/^[a-zA-Z]+$/i', $keyName)) return false;
                                break;
                            case 'word':
                                if (!preg_match('/^[a-zA-Z0-9_\@\!\#\$\%\^\&\*\(\)\.\|]+$/i', $keyName)) return false;
                                break;
                            case 'slashes':
                                if (preg_match('/\'|\"/', $keyName)) return false;
                                break;


                        }
                    }


                }


            } 

        }

        return true;

    }


}


?>