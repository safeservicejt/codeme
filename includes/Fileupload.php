<?php


class Fileupload
{
    private static $varName = '';
    private static $realPath = '';
    private static $fileName = '';
    private static $fileSize = '';
    private static $fileMimeType = '';
    private static $filePosition=0;
    private static $isMultiple='no';
    public $totalFiles=0;

    function __construct($varName = '')
    {
        $this->isMultiple='no';

        $this->varName = $varName;

        $this->filePosition=0;


        if(preg_match('/(\w+)\.(\d+)/i', $varName,$matches))
        {
            $this->varName=$matches[1];

            $this->filePosition=$matches[2];

            $this->isMultiple='yes';    

            $this->totalFiles=count($_FILES[$this->varName]['name']);  
        }
    }

    public function isValid()
    {
        if($this->isMultiple=='yes')
        {
             if (isset($_FILES[$this->varName])) {

                $fileName=$_FILES[$this->varName]['name'][$this->filePosition];

                if(isset($fileName[1]))
                {
                 return true;        
                }
                return false;
            }
            else
            {
                return false;
            }           

        }

        if (isset($_FILES[$this->varName])) {

            $fileName=$_FILES[$this->varName]['name'];

            if(isset($fileName[1]))
            {
                return true;        
            }
                return false;
        }

        return false;
    }

    public function move($fileDest = '', $newName = '')
    {
        // if($this->isMultiple=='yes')
        // {
        //     return $this->moveMultiple($fileDest, $newName);
        // }

        $tmpName='';

        if($this->isMultiple=='yes')
        {
            $newName = isset($newName[1]) ? $newName : $_FILES[$this->varName]['name'][$this->filePosition];
            $this->fileName = $_FILES[$this->varName]['name'][$this->filePosition];
            $this->fileSize = $_FILES[$this->varName]['size'][$this->filePosition];
            $this->fileMimeType = $_FILES[$this->varName]['type'][$this->filePosition];

            $tmpName=$_FILES[$this->varName]['tmp_name'][$this->filePosition];

        }
        else
        {
            $newName = isset($newName[1]) ? $newName : $_FILES[$this->varName]['name'];
            $this->fileName = $_FILES[$this->varName]['name'];
            $this->fileSize = $_FILES[$this->varName]['size'];
            $this->fileMimeType = $_FILES[$this->varName]['type'];
            
            $tmpName=$_FILES[$this->varName]['tmp_name'];
        }

        if(preg_match('/.*?\.\w+$/i', $fileDest))  
        {
            $fileDest = dirname($fileDest) . '/' . $newName;        
        }  
        else
        {
            $fileDest = $fileDest . $newName;     
        }


        if (move_uploaded_file($tmpName, $fileDest)) {

            $this->realPath = $fileDest;

            return true;
        }

        return false;

    }
    public function moveMultiple($fileDest = '', $newName = '')
    {
        $newName = isset($newName[1]) ? $newName : $_FILES[$this->varName]['name'][$this->filePosition];

        $this->fileName = basename($_FILES[$this->varName]['name'][$this->filePosition]);
        $this->fileSize = $_FILES[$this->varName]['size'][$this->filePosition];
        $this->fileMimeType = $_FILES[$this->varName]['type'][$this->filePosition];

        if(preg_match('/.*?\.\w+$/i', $fileDest))  
        {
            $fileDest = dirname($fileDest) . '/' . $newName;        
        }  
        else
        {
            $fileDest = $fileDest . $newName;     
        }
    

        if (move_uploaded_file($_FILES[$this->varName]['tmp_name'][$this->filePosition], $fileDest)) {

            $this->realPath = $fileDest;

            return true;
        }

        return false;

    }
    public function moveAll($fileDest = '')
    {
        $total=count($_FILES[$this->varName]['name']);

        $this->totalFiles=$total;

        for($i=0;$i<$total;$i++)
        {

            $newName = $_FILES[$this->varName]['name'][$this->filePosition];

            $this->fileName = basename($newName);
            $this->fileSize = $_FILES[$this->varName]['size'][$this->filePosition];
            $this->fileMimeType = $_FILES[$this->varName]['type'][$this->filePosition];

            if(preg_match('/.*?\.\w+$/i', $fileDest))  
            {
                $fileDest = dirname($fileDest) . '/' . $newName;        
            }  
            else
            {
                $fileDest = $fileDest . $newName;     
            }

            if (move_uploaded_file($_FILES[$this->varName]['tmp_name'][$this->filePosition], $fileDest)) {

                $this->realPath = $fileDest;

            }

            $this->filePosition=$this->filePosition+1;

        }
    }

    public function getFilesPath()
    {
        return Input::listFiles;
    }

    public function getRealPath()
    {
        return $this->realPath;
    }

    public function getClientOriginalName()
    {
        return $this->fileName;
    }

    public function getSize()
    {
        return $this->fileSize;
    }

    public function getMimeType()
    {
        return $this->fileMimeType;
    }

}

?>