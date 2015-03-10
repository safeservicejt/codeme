<?php

// File::downloadModule('http://test.vn/fruits.zip','contents/themes/','yes');

class File
{

    public function unzipModule($fullPath,$remove='no')
    {
        $zip = new Unzip($fullPath);

        $zip->extract();

        if($remove!='no')
        {
            unlink($fullPath);
        }

    }
    public function downloadModule($fileUrl,$savePath,$unzip='no')
    {
        // self::uploadFromUrl($fileUrl,$savePath);

        $imgData=Http::getDataUrl($fileUrl);

        $fileName=basename($fileUrl);

        $fullPath=ROOT_PATH.$savePath.$fileName;

        File::create($fullPath,$imgData);

        if($unzip!='no')
        {
            self::unzipModule($fullPath,'yes');
        }

    }

    public function uploadMultiModule($keyName='theFile',$savePath='contents/plugins/')
    {
        $resultData=self::uploadMultiple($keyName,$savePath);

        $total=count($resultData);

        for($i=0;$i<$total;$i++)
        {
            if(isset($resultData[$i][4]))
            {
                $thisPath=ROOT_PATH.$resultData[$i];    
                
                self::unzipModule($thisPath,'yes');            
            }

        }
    }

    public function exists($filePath = '')
    {
        if (isset($filePath[1]) && file_exists($filePath)) {
            return true;
        }

        return false;
    }

    public function create($filePath = '', $fileData = '', $writeMode = 'w')
    {
        $fp = fopen($filePath, $writeMode);
        fwrite($fp, $fileData);
        fclose($fp);
    }

    public function writeoverride($filePath = '', $fileData = '')
    {
        self::create($filePath, $fileData);
    }

    public function write($filePath = '', $fileData = '')
    {
        self::create($filePath, $fileData, 'a');
    }

    public function remove($filePath = '')
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function read($filePath = '')
    {

        if (file_exists($filePath)) {
            $data = file_get_contents($filePath);

            return $data;
        }

        return false;
    }

    public function readallline($filePath = '')
    {
        if (file_exists($filePath)) {
            $data = file($filePath);

            return $data;
        }

        return false;
    }

    public function getcontenttype($filePath = '')
    {
        if (file_exists($filePath)) {
            return mime_content_type($filePath);
        }

        return false;
    }

    public function getmodifytime($filePath = '')
    {
        if (file_exists($filePath)) {
            return filemtime($filePath);
        }

        return false;
    }

    public function getcreatetime($filePath = '')
    {
        if (file_exists($filePath)) {
            return fileatime($filePath);
        }

        return false;
    }

    public function getextension($fileName = '')
    {
        if (preg_match('/\.(\w+)$/i', $fileName, $matches)) {
            return $matches[1];
        }

        return false;
    }

    public function getsize($filePath = '')
    {
        if (file_exists($filePath)) {
            return filesize($filePath);
        }

        return false;

    }

    public function download($filePath,$fileName='')
    {
        if(isset($fileName[2]))
        {
            preg_match('/\.(\w+)$/i', $filePath,$matches);

            $fileName=Url::makeFriendly($fileName).'.'.$matches[1];
        }
        else
        {
            $fileName=basename($filePath);
        }
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$fileName);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        ob_clean();
        flush();
        readfile($filePath);
        exit;
    }

    public function move($fileSource = '', $fileDesc = '')
    {
        if (file_exists($fileSource)) {
            if (file_exists($fileDesc)) {
                unlink($fileDesc);
            }

            copy($fileSource, $fileDesc);

            unlink($fileSource);

            return true;
        }

        return false;

    }

    public function copy($fileSource = '', $fileDesc = '')
    {
        if (file_exists($fileSource)) {
            if (file_exists($fileDesc)) {
                unlink($fileDesc);
            }

            copy($fileSource, $fileDesc);

            return true;
        }

        return false;

    }

    public function rename($oldName = '', $newName = '')
    {
        if (file_exists($oldName)) {
            $dir = dirname($oldName);

            rename($oldName, $dir . '/' . $newName);

            return true;
        }

        return false;

    }

    public function name($Url = '')
    {
        return basename($Url);
    }


    public function upload($keyName='image',$shortPath='uploads/files/')
    {
        $name=$_FILES[$keyName]['name'];

        if(!preg_match('/.*?\.(\w+)/i', $name,$match))
        {
            return false;
        }

        $newName=String::randNumber(10);


        $shortPath.=$newName;

        mkdir(ROOT_PATH.$shortPath);

        $shortPath.='/'.$name;

        $fullPath=ROOT_PATH.$shortPath;

        move_uploaded_file($_FILES[$keyName]['tmp_name'], $fullPath);

        return $shortPath;
    }

    
    public function uploadMultiple($keyName='image',$shortPath='uploads/files/')
    {
        $name=$_FILES[$keyName]['name'][0];

        $resultData=array();

        if(!preg_match('/.*?\.\w+/i', $name))
        {
            return false;
        }

        $total=count($_FILES[$keyName]['name']);

        $tmpShortPath='';

        for($i=0;$i<$total;$i++)
        {
            $tmpShortPath=$shortPath;

            if(!preg_match('/.*?\.(\w+)/i', $_FILES[$keyName]['name'][$i],$matchName))
            {
                continue;
            }

            $newName=String::randNumber(10);

            $theName=$_FILES[$keyName]['name'][$i];

            $tmpShortPath.=$newName;

            mkdir(ROOT_PATH.$tmpShortPath);

            $tmpShortPath.='/'.$theName;

            $resultData[$i]=$tmpShortPath;

            $fullPath=ROOT_PATH.$tmpShortPath;

            move_uploaded_file($_FILES[$keyName]['tmp_name'][$i], $fullPath);
        }

        return $resultData;
    }

    public function uploadFromUrl($imgUrl,$shortPath='uploads/files/')
    {
        $imgUrl=trim($imgUrl);

        if(!preg_match('/http.*?\.(\w+)/i', $imgUrl,$match))
        {
            return false;
        }

        $newName=String::randNumber(10);

        $shortPath.=$newName;

        mkdir(ROOT_PATH.$shortPath);

        $shortPath.='/'.basename($imgUrl);

        $fullPath=ROOT_PATH.$shortPath;

        $imgData=Http::getDataUrl($imgUrl);

        File::create($fullPath,$imgData);

        return $shortPath;
    }

}


?>