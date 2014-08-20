<?php

class Validator
{

    private static $errorMessage='';

    public function make($varName = array())
    {
        $totalVarName = count($varName);

        $listKeys = array_keys($varName);

        for ($i = 0; $i < $totalVarName; $i++) {
            $keyName = $listKeys[$i];

            if (preg_match_all('/required|min|max|email/i', $varName[$keyName])) {

                $listRequire = explode('|', $varName[$keyName]);

                $totalRequire = count($listRequire);

                for ($j = 0; $j < $totalRequire; $j++) {
                    $reqValue = trim($listRequire[$j]);

                    if (preg_match('/(\w+)\:(\d+)/i', $reqValue, $matchesReqValues)) {

                        $matchLeft = $matchesReqValues[1];

                        $matchRight = (int)$matchesReqValues[2];

                        $keyValue = $_REQUEST[$keyName];

                        switch ($matchLeft) {
                            case 'min':
                                $matchRight--;

                                if (!isset($keyValue[$matchRight])) return false;

                                break;
                            case 'max':
                                $matchRight;

                                if (!isset($keyValue[$matchRight])) return false;

                                break;


                        }

                    } else {
                        switch ($reqValue) {
                            case 'required':
                                if (!isset($_REQUEST[$keyName])) return false;
                                break;
                            case 'email':
                                if (!preg_match('/.*?\@.*?\.\w+/i', $_REQUEST[$keyName])) return false;
                                break;

                        }
                    }


                }


            } else {
                if ($_REQUEST[$keyName] != $varName[$keyName]) {

                    return false;
                }
            }

        }

        return true;

    }

    public function isNumber($varName = '')
    {
        if (!is_array($varName)) {
            if (!is_numeric($_REQUEST[$varName])) {
                return false;
            }

            return true;
        }

        $totalVar = count($varName);

        for ($i = 0; $i < $totalVar; $i++) {
            $vName = $varName[$i];

            if (!is_numeric($_REQUEST[$vName])) {
                return false;
            }
        }

        return true;

    }


}


?>