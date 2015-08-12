<?php

class Validator
{

    public static $error = '';

    public static $message=array();

    public function getMessage()
    {
        $text=implode(', ', self::$message);

        return $text;
    }

    public function regex($varName=array())
    {
        $total=count($varName);

        $keyNames=array_keys($varName);

        for ($i=0; $i < $total; $i++) { 

            $theKey=$keyNames[$i];

            $theRequest=Request::get($theKey,'NOTEXISTS');

            if($theRequest=='NOTEXISTS')
            {
                self::$message[]='The request '.$theKey.' not exists. ';
                
                return false;
            }

            if(!preg_match($varName[$theKey], $theRequest))
            {
                self::$message[]='The request '.$theKey.' not match '.$varName[$theKey];

                return false;
            }

        }
    }



    public function make($varName = array(),$alert=array())
    {
        $totalVarName = count($varName);

        $listKeys = array_keys($varName);

        $keyValue='';

        for ($i = 0; $i < $totalVarName; $i++) {
            $keyName = $listKeys[$i];

            $keyValue = Request::get($keyName,'VALIDATOR');

            // if($keyValue=='VALIDATOR')
            // {
            //     // self::$error='The request '.$keyName.' not exists.';

            //     // return false;

            //     continue;
            // }

            if (preg_match('/required|min|max|email|number|alpha|word|slashes|space/i', $varName[$keyName])) {

                if(preg_match('/required/i', $varName[$keyName]) && $keyValue=='VALIDATOR')
                {
                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                    self::$message[]='Request '.$keyName.' not exists. ';

                    return false;
                }

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

                                    self::$message[]='Request '.$keyName.' not reach min length is '.$matchRight;

                                    return false;
                                } 

                                break;
                            case 'max':
                                $matchRight;

                                if (isset($keyValue[$matchRight]))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    self::$message[]='Request '.$keyName.' reached max length is '.$matchRight;

                                    return false;
                                } 

                                break;


                        }

                    } else {

                        switch ($reqValue) {
                            case 'required':
                                if ($keyValue=='VALIDATOR')
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';

                                    self::$message[]='Request '.$keyName.' not exists';

                                    return false;                                    
                                }
                                break;
                            case 'email':

                                if (!preg_match('/^.*?\@.*?\.\w+$/i', $keyValue))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';
                                    self::$message[]='Request '.$keyName.' not is email format';                                    
                                    return false;
                                } 
                                break;
                            case 'number':
                                if (!preg_match('/^\d+$/', $keyValue))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';
                                    self::$message[]='Request '.$keyName.' not is number';
                                    return false;                                    
                                }
                                break;

                            case 'slashes':
                                if (preg_match('/\'|\"/i', $keyValue))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';
                                    self::$message[]='Request '.$keyName.' lock by slashes';
                                    return false;                                    
                                }
                                break;
                            case 'space':
                                if (preg_match('/\s/i', $keyValue))
                                {
                                    self::$error=isset($alert[$keyName])?$alert[$keyName]:'';
                                    self::$message[]='Request '.$keyName.' has space(s)';
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


}




?>