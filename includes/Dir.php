<?php

class Dir
{

    public static function md5($dir)
    {
        if (!is_dir($dir))
        {
            return false;
        }
        
        $filemd5s = array();
        $d = dir($dir);

        while (false !== ($entry = $d->read()))
        {
            if ($entry != '.' && $entry != '..')
            {
                 if (is_dir($dir.'/'.$entry))
                 {
                     $filemd5s[] = self::md5($dir.'/'.$entry);
                 }
                 else
                 {
                     $filemd5s[] = md5_file($dir.'/'.$entry);
                 }
             }
        }
        $d->close();

        return md5(implode('', $filemd5s));
    }

    public static function copy($source, $dest) {
        // Dir::copy(ROOT_PATH.'application/lang/',ROOT_PATH.'caches/');
        if(is_dir($source)) {
            $dir_handle=opendir($source);
            while($file=readdir($dir_handle)){
                if($file!="." && $file!=".."){
                    if(is_dir($source."/".$file)){
                        if(!is_dir($dest."/".$file)){
                            mkdir($dest."/".$file);
                        }
                        self::copy($source."/".$file, $dest."/".$file);
                    } else {
                        copy($source."/".$file, $dest."/".$file);
                    }
                }
            }
            closedir($dir_handle);
        } else {
            copy($source, $dest);
        }
    }
    
    public static function remove($path)
    {
        // Dir::remove(ROOT_PATH.'test');
        $replaces=array(
            '/\/+/i'=>'/'
            );

        $path=preg_replace(array_keys($replaces), array_values($replaces), $path);

        $lenroot=strlen(ROOT_PATH);

        $lenpath=strlen($path);

        $lenroot2=(int)$lenroot+4;

        if((int)$lenpath <= $lenroot || (int)$lenpath <= $lenroot2)
        {
            return false;
        }

        if($path==ROOT_PATH)
        {
            return false;
        }

        if(preg_match('/\.\./', $path))
        {
            return false;
        }
        
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file)
            {
                self::remove(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        }

        else if (is_file($path) === true)
        {
            return unlink($path);
        }

        return false;        
    }
    
    public static function create($dirPath = '')
    {
        $filterPath=str_replace(ROOT_PATH,'',$dirPath);

        if(preg_match_all('/(\w+)/i',$filterPath,$matches))
        {
            $total=count($matches[1]);

            $megerPath=ROOT_PATH;

            for($i=0;$i<$total;$i++)
            {
                $megerPath=$megerPath.'/'.$matches[1][$i];

                if(!is_dir($megerPath))
                {
                    mkdir($megerPath); 

                    File::create($megerPath.'/index.html','');
                }

 
            }

        }
        else
        {
            mkdir($dirPath);

            File::create($dirPath.'/index.html','');
        }
  
    }

    public static function allDir($dir){

        $result=array();

        $ffs = scandir($dir);
        foreach($ffs as $ff){
            if($ff != '.' && $ff != '..'){

                // if(preg_match('/.*?\.\w+/i', $dir.$ff))
                $result[]=$dir.$ff;

                if(is_dir($dir.'/'.$ff))
                {

                    $tmp=self::allDir($dir.'/'.$ff);

                    $result=array_merge($result,$tmp);
                } 
            }
        }
        return $result;
    }    

    public static function all($dirPath = '')
    {
        if (is_dir($dirPath)) {
            return scandir($dirPath);
        }

        return false;
    }

    public static function listMatch($pattern)
    {
        // $listTxt=listMatch("*.txt");
        
        $dataMatches=glob($pattern);

        return $dataMatches;
    }

    public static function listDir($dirPath = '')
    {
        if (is_dir($dirPath)) {
            $files= scandir($dirPath);

            $total=count($files);

            $dir=array();

            for($i=0;$i<$total;$i++)
            {
                if(preg_match('/^[a-zA-Z0-9_\s]+$/i', $files[$i]))
                {
                    $dir[]= $files[$i];
                }

            }

            return $dir;
        }

        return false;        
    }
    public static function listFiles($dirPath = '')
    {
        if (is_dir($dirPath)) {
            $files= scandir($dirPath);

            $total=count($files);

            $dir=array();

            for($i=0;$i<$total;$i++)
            {
                if(preg_match('/^.*?\.\w+$/i', $files[$i]))
                {
                    $dir[]= $files[$i];
                }

            }

            return $dir;
        }

        return false;        
    }


}

?>