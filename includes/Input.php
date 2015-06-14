<?php


class Input extends Request
{

    function __construct()
    {

    }

    public function file($varName = '')
    {
        // $data = $_FILES[$varName];

        $upload = new Fileupload($varName);

        return $upload;

    }

}


?>