<?php

// File::downloadModule('http://test.vn/fruits.zip','contents/themes/','yes');

class File
{

    public static function md5($filePath='')
    {
        if(!file_exists($filePath))
        {
            return false;
        }

        return md5_file($filePath);

    }
    
    public static function unzipModule($fullPath,$remove='no')
    {
        if(!preg_match('/.*?\.(zip|rar)/i', $fullPath))
        {
            return false;
        }

        $zip = new Unzip($fullPath);

        $zip->extract();

        if($remove!='no')
        {
            unlink($fullPath);
        }

        $dirPath=dirname($fullPath).'/';

        $listFiles=Dir::listFiles($dirPath);

        return $listFiles;

    }
    public static function downloadModule($fileUrl,$savePath,$unzip='no')
    {
        // self::uploadFromUrl($fileUrl,$savePath);

        $imgData=Http::getDataUrl($fileUrl);

        // $fileName=basename($fileUrl);

        $fileName=PluginStoreApi::getFileName($fileUrl);

        $fullPath=ROOT_PATH.$savePath.$fileName;

        File::create($fullPath,$imgData);

        if($unzip!='no')
        {
            $listFiles=self::unzipModule($fullPath,'yes');

            return $listFiles;
        }

        return $savePath.$fileName;

    }

    public static function uploadMultiModule($keyName='theFile',$savePath='contents/plugins/')
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

    public static function exists($filePath = '')
    {
        if (isset($filePath[1]) && file_exists($filePath)) {
            return true;
        }

        return false;
    }

    public static function create($filePath = '', $fileData = '', $writeMode = 'w')
    {
        $fp = fopen($filePath, $writeMode);
        fwrite($fp, $fileData);
        fclose($fp);
    }

    public static function writeoverride($filePath = '', $fileData = '')
    {
        self::create($filePath, $fileData);
    }

    public static function write($filePath = '', $fileData = '')
    {
        self::create($filePath, $fileData, 'a');
    }

    public static function read($filePath = '')
    {

        if (file_exists($filePath)) {
            $data = file_get_contents($filePath);

            return $data;
        }

        return false;
    }

    public static function readallline($filePath = '')
    {
        if (file_exists($filePath)) {
            $data = file($filePath);

            return $data;
        }

        return false;
    }

    public static function getcontenttype($filePath = '')
    {
        /*
        'application/octet-stream'

         $mime_types = array(

                    'txt' => 'text/plain',
                    'htm' => 'text/html',
                    'html' => 'text/html',
                    'php' => 'text/html',
                    'css' => 'text/css',
                    'js' => 'application/javascript',
                    'json' => 'application/json',
                    'xml' => 'application/xml',
                    'swf' => 'application/x-shockwave-flash',
                    'flv' => 'video/x-flv',

                    // images
                    'png' => 'image/png',
                    'jpe' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'bmp' => 'image/bmp',
                    'ico' => 'image/vnd.microsoft.icon',
                    'tiff' => 'image/tiff',
                    'tif' => 'image/tiff',
                    'svg' => 'image/svg+xml',
                    'svgz' => 'image/svg+xml',

                    // archives
                    'zip' => 'application/zip',
                    'rar' => 'application/x-rar-compressed',
                    'exe' => 'application/x-msdownload',
                    'msi' => 'application/x-msdownload',
                    'cab' => 'application/vnd.ms-cab-compressed',

                    // audio/video
                    'mp3' => 'audio/mpeg',
                    'qt' => 'video/quicktime',
                    'mov' => 'video/quicktime',

                    // adobe
                    'pdf' => 'application/pdf',
                    'psd' => 'image/vnd.adobe.photoshop',
                    'ai' => 'application/postscript',
                    'eps' => 'application/postscript',
                    'ps' => 'application/postscript',

                    // ms office
                    'doc' => 'application/msword',
                    'rtf' => 'application/rtf',
                    'xls' => 'application/vnd.ms-excel',
                    'ppt' => 'application/vnd.ms-powerpoint',

                    // open office
                    'odt' => 'application/vnd.oasis.opendocument.text',
                    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
                );



        */

        if (file_exists($filePath)) {
            return mime_content_type($filePath);
        }

        return false;
    }

    public static function getmodifytime($filePath = '')
    {
        if (file_exists($filePath)) {
            return filemtime($filePath);
        }

        return false;
    }

    public static function getcreatetime($filePath = '')
    {
        if (file_exists($filePath)) {
            return fileatime($filePath);
        }

        return false;
    }

    public static function getextension($fileName = '')
    {
        if (preg_match('/\.(\w+)$/i', $fileName, $matches)) {
            return $matches[1];
        }

        return false;
    }

    public static function getsize($filePath = '')
    {
        if (file_exists($filePath)) {
            return filesize($filePath);
        }

        return false;

    }

    public static function download($filePath,$fileName='')
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

    public static function move($fileSource = '', $fileDesc = '')
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

    public static function copy($fileSource = '', $fileDesc = '')
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

    public static function fullCopy( $source, $target ) {
        if ( is_dir( $source ) ) {
            @mkdir( $target );
            $d = dir( $source );
            while ( FALSE !== ( $entry = $d->read() ) ) {
                if ( $entry == '.' || $entry == '..' ) {
                    continue;
                }
                $Entry = $source . '/' . $entry; 
                if ( is_dir( $Entry ) ) {
                    self::fullCopy( $Entry, $target . '/' . $entry );
                    continue;
                }
                copy( $Entry, $target . '/' . $entry );
            }

            $d->close();
        }else {
            copy( $source, $target );
        }
    }

    public static function rename($oldName = '', $newName = '')
    {
        if (file_exists($oldName)) {
            $dir = dirname($oldName);

            rename($oldName, $dir . '/' . $newName);

            return true;
        }

        return false;

    }

    public static function name($Url = '')
    {
        return basename($Url);
    }


    public static function upload($keyName='image',$shortPath='uploads/files/')
    {
        $name=$_FILES[$keyName]['name'];

        if(!preg_match('/^.*?\.(\w+)$/i', $name,$match))
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

    
    public static function uploadMultiple($keyName='image',$shortPath='uploads/files/')
    {
        $name=$_FILES[$keyName]['name'][0];

        $resultData=array();

        if(!preg_match('/^.*?\.\w+$/i', $name))
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

    public static function uploadFromUrl($imgUrl,$shortPath='uploads/files/')
    {
        $imgUrl=trim($imgUrl);

        if(!preg_match('/^http.*?\.(\w+)/i', $imgUrl,$match))
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

    public static function remove($filePath)
    {
        if(preg_match('/.*?\.\w+/i', $filePath) && file_exists($filePath))
        {
            unlink($filePath);

            $filePath=dirname($filePath);

            if(file_exists($filePath.'/index.html'))
            {
                unlink($filePath.'/index.html');
            }

            rmdir($filePath);
        }
    }

    public static function removeOnly($filePath)
    {
        if(preg_match('/.*?\.\w+/i', $filePath) && file_exists($filePath))
        {
            unlink($filePath);
        }
    }


}


?>