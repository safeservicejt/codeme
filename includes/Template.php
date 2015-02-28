<?php

class Template
{

    public static $loadPath = '';

    public function setPath($path)
    {
        $path=!isset($path[2])?VIEWS_PATH:$path;

        self::$loadPath=$path;
    }

    public function getPath()
    {
        $path=!isset(self::$loadPath[2])?VIEWS_PATH:self::$loadPath;

        self::$loadPath=$path;

        return $path;
    }

    public function make($viewName = '', $viewData = array())
    {
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

        // $path = VIEWS_PATH . $viewName . '.php';
        $path = self::getPath() . $viewName . '.php';

        if (!file_exists($path)) {

            ob_end_clean();

            // include(VIEWS_PATH . 'page_not_found.php');
            include(self::getPath() . 'page_not_found.php');

            die();
        }

        $total_data = count($viewData);

        if ($total_data > 0) extract($viewData);

        $path=self::parseData($path);

        // die($path);

        include($path);
    }

    public function parseData($path)
    {
    	$resultPath=$path;

    	$loadData=file_get_contents($path);

    	// die($loadData);

    	$fileMD5=md5($path.$loadData);

    	$md5Path=ROOT_PATH.'application/caches/templates/'.$fileMD5.'.php';

    	if(file_exists($md5Path))
    	{
    		$resultPath=$md5Path;
    		// die('dsd');
    		return $resultPath;
    	}

    	$loadData=self::parseExtends($loadData);



    	$replace=array(
    		'/\{include file="(.*?)"\}/i'=>'<?php Template::make($1);?>',
    		'/\{include file=\'(.*?)\'\}/i'=>'<?php Template::make($1);?>',
    		'/\{include "(.*?)"\}/i'=>'<?php Template::make($1);?>',
    		'/\{include \'(.*?)\'\}/i'=>'<?php Template::make($1);?>',
    		'/\{include (.*?)\}/i'=>'<?php Template::make($1);?>',

    		'/\{include_php file="(.*?)"\}/i'=>'<?php include("$1")?>',
    		'/\{include_php file=\'(.*?)\'\}/i'=>'<?php include("$1")?>',
    		'/\{include_php "(.*?)"\}/i'=>'<?php include("$1")?>',
    		'/\{include_php \'(.*?)\'\}/i'=>'<?php include("$1")?>',
    		'/\{include_php (.*?)\}/i'=>'<?php include("$1")?>',

    		'/\{assign var="(\w+)" value="(.*?)"\}/i'=>'<?php $$1="$2";?>',
    		'/\{\$(.*?)=(.*?)\}/i'=>'<?php $$1=$2;?>',
    		'/\{(.*?)=(.*?)\}/i'=>'<?php $$1=$2;?>',
    		'/\{(\w+)=(.*?)\}/i'=>'<?php $$1=$2;?>',
    		'/\{\$(.*?) (.*?)\}/i'=>'<?php $$1 $2;?>',

    		'/\{\$(.*?)\}/i'=>'<?php echo $$1;?>',

    		'/\{(\w+)::(\w+)\((.*?)\)\}/i'=>'<?php $1::$2($3);?>',

    		'/\{if (.*?)\}/i'=>'<?php if($1){ ?>',
    		'/\{elseif (.*?)\}/i'=>'<?php }elseif($1){ ?>',
    		'/\{else\}/i'=>'<?php }else{ ?>',
    		'/\{\/if\}/i'=>'<?php } ?>',

    		'/\{block .*?\}.*?\{\/block\}/i'=>''
    		);

    	$loadData=preg_replace(array_keys($replace), array_values($replace), $loadData);

    	Cache::saveKey('templates/'.$fileMD5,$loadData,'.php');

    	// die($loadData);

    	$resultPath=ROOT_PATH.'application/caches/templates/'.$fileMD5.'.php';

    	return $resultPath;
    }

    public function parseExtends($loadData)
    {
    	// $replace=array(
    	// 	'/\{extends file=\'(.*?)\'\}/i'=>self::loadExtends("$1"),
    	// 	'/\{extends file="(.*?)"\}/i'=>self::loadExtends("$1"),
    	// 	'/\{extends \'(.*?)\'\}/i'=>self::loadExtends("$1"),
    	// 	'/\{extends "(.*?)"\}/i'=>self::loadExtends("$1")
    	// 	);

    	// $loadData=preg_replace(array_keys($replace), array_values($replace), $loadData);

    	preg_match_all('/\{extends (\'|\"|file=\'|file=\")(.*?)(\'|\")\}/i', $loadData, $matches);

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