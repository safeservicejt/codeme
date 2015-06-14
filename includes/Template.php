<?php

class Template
{

    public function parseData($path)
    {
    	$resultPath=$path;

    	// $loadData=file_get_contents($path);

    	// die($loadData);

    	$fileMD5=md5_file($path.$loadData);

    	$md5Path=ROOT_PATH.'application/caches/templates/'.$fileMD5.'.php';

    	if(file_exists($md5Path))
    	{
    		$resultPath=$md5Path;
    		// die('dsd');
    		return $resultPath;
    	}
        
        $loadData=file_get_contents($path);

    	$loadData=self::parseExtends($loadData);

        $loadData=self::parseFriendlyFunction($loadData);
        
    	$replace=array(

    		'/\{\{assign var="(\w+)" value="(.*?)"\}\}/i'=>'<?php $$1="$2";?>',
    		'/\{\{\$(.*?)=(.*?)\}\}/i'=>'<?php $$1=$2;?>',
    		'/\{\{(.*?)=(.*?)\}\}/i'=>'<?php $$1=$2;?>',
    		'/\{\{(\w+)=(.*?)\}\}/i'=>'<?php $$1=$2;?>',
    		'/\{\{\$(.*?) (.*?)\}\}/i'=>'<?php $$1 $2;?>',

            '/\{\{\$(.*?)\}\}/i'=>'<?php echo $$1;?>',

    		'/\{\{(\w+)::(\w+)\((.*?)\)\}\}/i'=>'<?php $1::$2($3);?>',

    		'/\{\{if (.*?)\}\}/i'=>'<?php if($1){ ?>',
    		'/\{\{elseif (.*?)\}\}/i'=>'<?php }elseif($1){ ?>',
    		'/\{\{else\}\}/i'=>'<?php }else{ ?>',
            '/\{\{\/if\}\}/i'=>'<?php } ?>',

            '/\<\?=(.*?)\?\>/i'=>'<?php echo $1 ?>',

            '/\{\{loop total=(\d+)\}\}/i'=>'<?php for($i=1;$i<=$1;$i++){ ?>',
            '/\{\{loop:(\d+)\}\}/i'=>'<?php for($i=1;$i<=$1;$i++){ ?>',

            '/\{\{\/loop\}\}/i'=>'<?php } ?>',

            '/\{\{foreach (\w+) as (\w+)\}\}/i'=>'<?php foreach($$1 as $$2){ ?>',
            '/\{\{endfor\}\}/i'=>'<?php } ?>',

            '/\(\{\{(\w+)\.(\w+)\}\}\)/i'=>'$$1["$2"]',
            '/\(\{\{(\w+)\.(\w+)\.(\w+)\}\}\)/i'=>'$$1["$2"]["$3"]',
            '/\(\{\{(\w+)\.(\w+)\.(\w+)\.(\w+)\}\}\)/i'=>'$$1["$2"]["$3"]["$4"]',

            '/\{\{(\w+)\.(\w+)\}\}/i'=>'<?php echo $$1["$2"];?>',
            '/\{\{(\w+)\.(\w+)\.(\w+)\}\}/i'=>'<?php echo $$1["$2"]["$3"];?>',
            '/\{\{(\w+)\.(\w+)\.(\w+)\.(\w+)\}\}/i'=>'<?php echo $$1["$2"]["$3"]["$4"];?>',

            '/\{\{(\w+) or (.*?)\}\}/i'=>'<?php $$1=isset($$1[0])?$$1:$2; echo $$1;?>',
            '/\{\{(\$\w+) or (.*?)\}\}/i'=>'<?php $1=isset($1[0])?$1:$2; echo $1;?>',

    		'/\{\{block .*?\}\}.*?\{\{\/block\}\}/i'=>''
    		);

    	$loadData=preg_replace(array_keys($replace), array_values($replace), $loadData);

    	Cache::saveKey('templates/'.$fileMD5,$loadData,'.php');

    	// die($loadData);

    	$resultPath=ROOT_PATH.'application/caches/templates/'.$fileMD5.'.php';

    	return $resultPath;
    }

    public function parseFriendlyFunction($loadData)
    {
         preg_match_all('/(\{\{(\w+|\w+\.\w+) | .*?\}\})/i', $loadData, $matches);

         $total=count($matches[0]);

         $replaces=array(
            '/:\w+:\w+/i'=>'',
            '/,\)/i'=>')'
            );  

         $replaceSource=array();

         $replaceDesc=array();

         for($i=0; $i < $total; $i++) { 

            $keyName=trim(substr($matches[1][$i], 1,strlen($matches[1][$i])-1));

            $i++;

            $funcs=trim(substr($matches[1][$i], 0,strlen($matches[1][$i])-1));

            $pattern='{'.$keyName.' | '.$funcs.'}';

            $replaceSource[]=$pattern;

            if(preg_match('/(\w+)\.(\w+)/', $keyName,$matchKeys))
            {
                $keyName='$'.$matchKeys[1].'["'.$matchKeys[2].'"]';
            }
            else
            {
                $keyName='$'.$keyName;
            }

            $parseFunc=explode('|', $funcs);

            $totalFunc=count($parseFunc);

            for($j=0;$j<$totalFunc;$j++)
            {
                $funcName=trim($parseFunc[$j]);

                $addon='';

                if(preg_match_all('/:(\w+)/i', $funcName, $matchAddons))
                {
                    if(!preg_match('/\w+::'.$matchAddons[1][0].'/i', $funcName))
                    {
                        $totalAddon=count($matchAddons[1]);

                        for($u=0;$u<$totalAddon;$u++)
                        {
                            $addon.=$matchAddons[1][$u].', ';
                            
                        }
                    }
                    // print_r($matchAddons);
                    // die();
                    $addon=','.substr($addon, 0,strlen($addon)-2);
                }

                $keyName=$funcName.'('.$keyName.$addon.')';

                
            }

            $keyName=preg_replace(array_keys($replaces), array_values($replaces), $keyName);

            $replaceDesc[]=$keyName;

         }

         $loadData=str_replace($replaceSource, $replaceDesc, $loadData);

         return $loadData;

    }

    public function parseExtends($loadData)
    {
    	// $replace=array(
    	// 	'/\{\{extends file=\'(.*?)\'\}\}/i'=>self::loadExtends("$1"),
    	// 	'/\{\{extends file="(.*?)"\}\}/i'=>self::loadExtends("$1"),
    	// 	'/\{\{extends \'(.*?)\'\}\}/i'=>self::loadExtends("$1"),
    	// 	'/\{\{extends "(.*?)"\}\}/i'=>self::loadExtends("$1")
    	// 	);

    	// $loadData=preg_replace(array_keys($replace), array_values($replace), $loadData);

    	preg_match_all('/\{\{extends (\'|\"|file=\'|file=\")(.*?)(\'|\")\}\}/i', $loadData, $matches);

    	$total=count($matches[2]);

    	$replace=array();

    	for($i=0;$i<$total;$i++)
    	{
    		$viewName=$matches[2][$i];

    		$pattern=$matches[0][$i];

    		if(!preg_match('/\.php/i', $viewName))
    		{
    			$viewName=$viewName.'.php';
    		}

    		$path=self::getPath().$viewName;

    		if(file_exists($path))
    		{
    			$getData=file_get_contents($path);

    			$replace[$pattern]=$getData;
    		}
    	}

    	$loadData=str_replace(array_keys($replace), array_values($replace), $loadData);

    	// $path=self::getPath().$viewName.'.php';

    	// print_r($loadData);

    	// die();

    	return $loadData;
    }

    public function loadExtends($viewName)
    {
    	$path=self::getPath().$viewName.'.php';

    	if(!file_exists($path))
    	{
    		return '';
    	}

    	$data=file_get_contents($path);

    	return $data;
    }
}
?>