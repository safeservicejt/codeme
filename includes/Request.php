<?php


class Request
{
    public function isImage($keyName)
    {
        if(preg_match('/(\w+)\.(\d+)/i', $keyName,$match))
        {
            if(isset($_FILES[$match[1]][$match[2]]) && preg_match('/.*?\.\w+$/i', $_FILES[$match[1]][$match[2]]['name']))
            {
                return true;
            }               
        }
        else
        {
            if(isset($_FILES[$keyName]) && preg_match('/.*?\.\w+$/i', $_FILES[$keyName]['name']))
            {
                return true;
            }            
        }


        return false;
    }

    public function hasFile($keyName)
    {
        if(preg_match('/(\w+)\.(\d+)/i', $keyName,$match))
        {
            return true;              
        }
        elseif(preg_match('/(\w+)/i', $keyName,$match))
        {
            return true;          
        }


        return false;
    }



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

    public function forget($reqName = '', $reqValue = '')
    {
        $result = '';

        if (!preg_match('/(\w+)\.(\w+)/i', $reqName, $matchesName)) {
            unset($_REQUEST[$reqName]);

        } else {
            $reqName = $matchesName[1];
            $postion = $matchesName[2];

            unset($_REQUEST[$reqName][$postion]);
        }

        return $result;

    }    
    
    public function getPost($reqName = '', $reqValue = '')
    {
        if(!isset($reqName[1]))
        {
            return $_POST;
        }

        $result = '';

        if (!preg_match('/(\w+)\.(\w+)/i', $reqName, $matchesName)) {
            $result = isset($_POST[$reqName]) ? $_POST[$reqName] : $reqValue;

        } else {
            $reqName = $matchesName[1];
            $postion = $matchesName[2];

            $result = isset($_POST[$reqName][$postion]) ? $_POST[$reqName][$postion] : $reqValue;
        }

        return $result;

    }

    public function isPost($reqKey)
    {
        if(!isset($reqKey[0]))
        {
            return false;
        }
        
        if(!isset($_POST[$reqKey]))
        {
            return false;
        }

        return true;
    }
    public function isGet($reqKey)
    {
        if(!isset($reqKey[0]))
        {
            return false;
        }

        if(!isset($_GET[$reqKey]))
        {
            return false;
        }

        return true;
    }
    public function isFile($reqKey)
    {
        if(!isset($reqKey[0]))
        {
            return false;
        }

        if(!isset($_FILES[$reqKey]['tmp_name']))
        {
            return false;
        }

        return true;
    }

    public function make($reqName = '', $reqValue = '')
    {
        if (!preg_match('/(\w+)\.(\w+)/i', $reqName, $matchesName)) {

            $_REQUEST[$reqName]=$reqValue;

        } else {
            $reqName = $matchesName[1];
            $postion = $matchesName[2];

            $_REQUEST[$reqName][$postion]=$reqValue;
        }
    }

    public function hasElement($reqName = '')
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

    public function has($reqName = '')
    {

        if(!is_array($reqName))
        {
            $result=self::hasElement($reqName);

            return $result;
        }
        else
        {
            $total=count($reqName);

            for ($i=0; $i < $total; $i++) { 

                $result=self::hasElement($reqName[$i]);

                if(!$result)
                {
                    return false;
                }
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