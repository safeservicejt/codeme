<?php


class Request
{
    public function get($reqName = '', $reqValue = '')
    {
        $result = '';

        if (!preg_match('/(\w+)\.(\w+)/i', $reqName, $matchesName)) {
            $result = isset($_REQUEST[$reqName]) ? $_REQUEST[$reqName] : $reqValue;

        } else {
            $reqName = $matchesName[1];
            $postion = $matchesName[2];

            $result = isset($_REQUEST[$reqName][$postion]) ? $_REQUEST[$reqName][$postion] : $reqValue;
        }

        return $result;

    }

    public function has($reqName = '')
    {
        if (!preg_match('/(\w+)\.(\w+)/i', $reqName, $matchesName)) {
            if (!isset($_REQUEST[$reqName])) {
                return false;
            }

            return true;
        } else {
            $reqName = $matchesName[1];
            $postion = $matchesName[2];

            if (!isset($_REQUEST[$reqName][$postion])) {
                return false;
            }
            return true;
        }

    }

    public function all()
    {
        if (isset($_REQUEST['load'])) unset($_REQUEST['load']);
        return $_REQUEST;
    }

    public function only($reqName = '')
    {
        if (isset($_REQUEST['load'])) unset($_REQUEST['load']);

        if (is_array($reqName)) {
            $totalName = count($reqName);
            $totalReq = count($_REQUEST);

            if ($totalName > 0 && $totalReq > 0) {

                $data = array();

                foreach ($reqName as $value) {

                    if (isset($_REQUEST[$value])) {
                        $data[$value] = $_REQUEST[$value];
                    }

                }

                return $data;

            }

        }

        if (isset($_REQUEST[$reqName])) return $_REQUEST[$reqName];


    }

    public function except($reqName = array())
    {
        if (isset($_REQUEST['load'])) unset($_REQUEST['load']);   
            
        $totalName = count($reqName);

        for($i=0;$i<$totalName;$i++)
        {
            $keyName=$reqName[$i];

             if (!preg_match('/(\w+)\.(\w+)/i', $keyName, $matchesName)) {
                if(isset($_REQUEST[$keyName]))
                {
                    unset($_REQUEST[$keyName]);
                }
            } else {
                $keyName = $matchesName[1];
                $postion = $matchesName[2];

                            // print_r($_REQUEST[$keyName][$postion]);die();

                if (isset($_REQUEST[$keyName][$postion])) {


                    unset($_REQUEST[$keyName][$postion]);
                }
            }           
        }

        return $_REQUEST;

    }


}


?>