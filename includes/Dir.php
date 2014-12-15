<?php

class Dir
{

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