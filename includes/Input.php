<?php


class Input extends Request
{
    function __construct()
    {

    }

    public function file($varName = '')
    {
        $data = $_FILES[$varName];

        $upload = new Fileupload($varName);

        return $upload;

    }

}

class Fileupload
{
    private static $varName = '';
    private static $realPath = '';
    private static $fileName = '';
    private static $fileSize = '';
    private static $fileMimeType = '';


    function __construct($varName = '')
    {
        self::$varName = $varName;
    }

    public function isValid()
    {
        if (isset($_FILES[self::$varName])) {
            return true;
        }

        return false;
    }

    public function move($fileDest = '', $newName = '')
    {
        $newName = isset($newName[1]) ? $newName : $_FILES[self::$varName]['name'];

        self::$fileName = basename($_FILES[self::$varName]['name']);
        self::$fileSize = $_FILES[self::$varName]['size'];
        self::$fileMimeType = $_FILES[self::$varName]['type'];

        $fileDest = dirname($fileDest) . '/' . $newName;

        if (move_uploaded_file($_FILES[self::$varName]['tmp_name'], $fileDest)) {

            self::$realPath = $fileDest;

            return true;
        }

        return false;

    }

    public function getRealPath()
    {
        return self::$realPath;
    }

    public function getClientOriginalName()
    {
        return self::$fileName;
    }

    public function getSize()
    {
        return self::$fileSize;
    }

    public function getMimeType()
    {
        return self::$fileMimeType;
    }

}

?>