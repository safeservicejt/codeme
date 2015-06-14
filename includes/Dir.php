<?php

class Dir
{

    public function md5($dir)
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

    public function copy($source, $dest) {
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
    public function remove($path)
    {
        // Dir::remove(ROOT_PATH.'test');
        
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
    public function create($dirPath = '')
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
                }

 
            }

        }
        else
        {
            mkdir($dirPath);
        }
  
    }

    public function all($dirPath = '')
    {
        if (is_dir($dirPath)) {
            return scandir($dirPath);
        }

        return false;
    }

    public function listMatch($pattern)
    {
        // $listTxt=listMatch("*.txt");
        
        $dataMatches=glob($pattern);

        return $dataMatches;
    }

    public function listDir($dirPath = '')
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
    public function listFiles($dirPath = '')
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