<?php


class Request
{
    public function get($reqName = '', $reqValue = '')
    {
        $result = '';

        if (!preg_match('/(\w+)\.(\d+)/i', $reqName, $matchesName)) {
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
        if (!preg_match('/(\w+)\.(\d+)/i', $reqName, $matchesName)) {
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
        return $_REQUEST;
    }

    public function only($reqName = array())
    {
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

    public function except($reqName = array())
    {
        $totalName = count($reqName);
        $totalReq = count($_REQUEST);

        if ($totalName > 0 && $totalReq > 0) {

            foreach ($reqName as $value) {

                if (isset($_REQUEST[$value])) {
                    unset($_REQUEST[$value]);
                }

            }

            return $_REQUEST;

        }

    }
}



?>