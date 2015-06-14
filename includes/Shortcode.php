<?php

class Shortcode
{

// Shortcode::add('youtube','make_youtube_video');

	public function templateAdd($scName,$funcName)
	{
		if(!isset(Plugins::$listShortCodes['shortcode']))
		{
			Plugins::$listShortCodes['shortcode']=array();
		}		

		$data=debug_backtrace();	

		$pluginPath=dirname($data[0]['file']).'/';

		$folderName=basename($pluginPath);	

		$post=array();

		$post['name']=$scName;

		$post['func']=$funcName;

		$post['path']=THEMES_PATH.$folderName.'/';

		$post['foldername']=$folderName;

		$post['zonename']='shortcode';

		$post['status']=1;

		$post['istemplate']='yes';

		array_push(Plugins::$listShortCodes['shortcode'], $post);

		if(isset(Plugins::$listShortCodes['loaded']))
		{
			unset(Plugins::$listShortCodes['loaded']);
		}

		// print_r(Plugins::$listShortCodes);
		// die();
	}

	public function add($scName,$funcName)
	{
		$data=debug_backtrace();	

		$path=dirname($data[0]['file']).'/';

		$post=array();

		$post['content']=$scName;

		$post['func']=$funcName;

		$pluginPath=$path;

		$folderName=basename($path);

		$post['foldername']=$folderName;

		$post['zonename']='shortcode';

		$post['type']='shortcode';

		// Plugins::add('shortcode',$post);
		
		if(!PluginsMeta::insert($post))
		{
			return false;			
		}

	
		PluginsZone::addPlugin($post['zonename'],$post);

	}


	public function load($content)
	{

		// $content=self::parse($content);

		if(!isset(Plugins::$listCaches['shortcode']))
		{
			return $content;
		}

		$loadData=Plugins::$listCaches['shortcode'];

		// print_r($loadData);die();

		$total=count($loadData);

		$foldername='';

		$func='';

		$scName='';

		$pluginPath='';

		$parse='';

		$resultData='';

		$resultSC='';

		for($i=0;$i<$total;$i++)
		{
			$theShortcode=$loadData[$i];

			if((int)$theShortcode['status']==0)
			{
				continue;
			}

			$foldername=$theShortcode['foldername'];

			$func=$theShortcode['func'];

			$scName=$theShortcode['name'];

			$pluginPath=PLUGINS_PATH.$foldername.'/'.$foldername.'.php';

			if(isset($theShortcode['path']) && isset($theShortcode['istemplate']))
			{
				$pluginPath=$theShortcode['path'].'/shortcode.php';
			}


			$parse='';


			if(!function_exists($func) || isset($theShortcode['istemplate']))
			{
				if(file_exists($pluginPath))
				{
					if(!isset($theShortcode['istemplate']))
					include($pluginPath);
				}

				if(!$resultSC=self::parseOpenClose($scName,$content))
				{
					$resultSC=self::parseAlone($scName,$content);

				}

				// print_r($theShortcode);die();
				$totalResult=count($resultSC);

				for($e=0;$e<$totalResult;$e++)
				{
					$resultData=$func($resultSC[$e]);
					
				// print_r($resultSC);die();

					$content=str_replace($resultSC[$e]['real'], $resultData, $content);
					
					$resultData='';
				}
			}

		}


		return $content;

	}

	public function loadInTemplate($content)
	{

		// $content=self::parse($content);

		if(!isset(Plugins::$listShortCodes['shortcode']))
		{
			return $content;
		}

		$loadData=Plugins::$listShortCodes['shortcode'];

		// print_r($loadData);die();

		$total=count($loadData);

		$foldername='';

		$func='';

		$scName='';

		$pluginPath='';

		$parse='';

		$resultData='';

		$resultSC='';

		for($i=0;$i<$total;$i++)
		{
			$theShortcode=$loadData[$i];

			if((int)$theShortcode['status']==0)
			{
				continue;
			}

			$foldername=$theShortcode['foldername'];

			$func=$theShortcode['func'];

			$scName=$theShortcode['name'];

			$pluginPath=PLUGINS_PATH.$foldername.'/'.$foldername.'.php';

			if(isset($theShortcode['path']) && isset($theShortcode['istemplate']))
			{
				$pluginPath=$theShortcode['path'].'shortcode.php';
			}


			$parse='';


			if(!function_exists($func) || isset($theShortcode['istemplate']))
			{
				if(file_exists($pluginPath))
				{
					if(!isset($theShortcode['istemplate']))
					include($pluginPath);
				}

				if(!$resultSC=self::parseOpenClose($scName,$content))
				{
					$resultSC=self::parseAlone($scName,$content);

				}

				// print_r($theShortcode);die();
				$totalResult=count($resultSC);

				for($e=0;$e<$totalResult;$e++)
				{
					$resultData=$func($resultSC[$e]);
					
				// print_r($resultSC);die();

					$content=str_replace($resultSC[$e]['real'], $resultData, $content);
					
					$resultData='';
				}
			}

		}

		return $content;

	}

	public function parseAlone($scName='',$inputData='')
	{

		$loadData=array();

		if(!preg_match_all('/\['.$scName.'(.*?)\]/i', $inputData, $matches))
		{
			return false;
		}

		$totalSC=count($matches[1]);

		for($j=0;$j<$totalSC;$j++)
		{

			$attr=$matches[1][$j];

			$reAttr=$attr;
			if(isset($attr[2]))
			{
				$reAttr=' '.$attr;

				$loadData[$j]['real']='['.$scName.$reAttr.']';

				$replaces=array('"',"'");

				$listReplaces=str_replace($replaces, array(), $attr);

				$listExplode=explode(' ',$listReplaces);

				$total=count($listExplode);

				for($i=0;$i<$total;$i++)
				{
					$parse=explode("=", $listExplode[$i]);

					$loadData[$j][$parse[0]]=$parse[1];
				}				
			}			

		}

		return $loadData;

	}
	public function parseOpenClose($scName='',$inputData='')
	{

		$loadData=array();

		if(!preg_match_all('/\['.$scName.'(.*?)\](.*?)\[\/'.$scName.'\]/i', $inputData, $matches))
		{
			return false;
		}

		$totalSC=count($matches[1]);

		for($j=0;$j<$totalSC;$j++)
		{

			$attr=$matches[1][$j];

			$value=$matches[2][$j];

			$loadData[$j]['value']=$value;

			$reAttr=$attr;
			if(isset($attr[2]))
			{
				$reAttr=' '.$attr;
			}

			$loadData[$j]['real']='['.$scName.$reAttr.']'.$value.'[/'.$scName.']';

			$loadData[$j]['attr']=array();

			if(isset($attr[2]))
			{
				$replaces=array('"',"'");

				$listReplaces=str_replace($replaces, array(), $attr);

				$listExplode=explode(' ',$listReplaces);

				$total=count($listExplode);

				for($i=0;$i<$total;$i++)
				{
					$parse=explode("=", $listExplode[$i]);

					$loadData[$j]['attr'][$parse[0]]=$parse[1];
				}				
			}
		}

		return $loadData;

	}

	public function toHTML($str)
	{
		$str=trim($str);
	// BBcode array
	    $find = array(
	        '~\[b\](.*?)\[/b\]~s',
	        '~\[i\](.*?)\[/i\]~s',
	        '~\[u\](.*?)\[/u\]~s',
	        '~\[quote\](.*?)\[/quote\]~s',
	        '~\[size=(.*?)\](.*?)\[/size\]~s',
	        '~\[color=(.*?)\](.*?)\[/color\]~s',
	        '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
	        '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
	        '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))".*?>~s',
	        '~\[img:auto\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
	        '~\[img:auto-responsive\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',

	        '~\[url href=(.*?) class=(.*?)\](.*?)\[\/url\]~s',
	        '~\[label class=(.*?)\](.*?)\[\/label\]~s',
	        '~\[alert class=(.*?)\](.*?)\[\/alert\]~s',

	        '~\[panelbody\](.*?)\[\/panelbody\]~s',
	        '~\[paneltitle\](.*?)\[\/paneltitle\]~s',
	        '~\[panel\](.*?)\[\/panel\]~s',
	        '~\[panel class=.*?\](.*?)\[\/panel\]~s',

	        '~\[taburl:active id=(.*?)\](.*?)\[\/taburl\]~s',
	        '~\[taburl id=(.*?)\](.*?)\[\/taburl\]~s',
	        '~\[navtabs\](.*?)\[\/navtabs\]~s',
	        '~\[tabpanel:active id=(.*?)\](.*?)\[\/tabpanel\]~s',
	        '~\[tabpanel id=(.*?)\](.*?)\[\/tabpanel\]~s',
	        '~\[tabcontent\](.*?)\[\/tabcontent\]~s',
	        '~\[tab\](.*?)\[\/tab\]~s',

	        '~\[row\](.*?)\[\/row\]~s',
	        '~\[row class=(.*?)\](.*?)\[\/row\]~s',
	        '~\[row id=(.*?)\](.*?)\[\/row\]~s',
	        '~\[row class=(.*?) id=(.*?)\](.*?)\[\/row\]~s',
	        '~\[row id=(.*?) class=(.*?)\](.*?)\[\/row\]~s',

	        '~\[col\](.*?)\[\/col\]~s',
	        '~\[col class=(.*?)\](.*?)\[\/col\]~s',
	        '~\[col id=(.*?)\](.*?)\[\/col\]~s',
	        '~\[col class=(.*?) id=(.*?)\](.*?)\[\/col\]~s',
	        '~\[col id=(.*?) class=(.*?)\](.*?)\[\/col\]~s',

	        '~\[img class=(.*?)\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',

	        '~\[dropdown\](.*?)\[\/dropdown\]~s',
	        '~\[drbutton class=(.*?)\](.*?)\[\/drbutton\]~s',
	        '~\[drmenu\](.*?)\[\/drmenu\]~s',
	        '~\[drlink href=(.*?)\](.*?)\[\/drlink\]~s',

	        '~\[bxslider\](.*?)\[\/bxslider\]~s',
	        '~\[bximg src=(.*?)\]~s',
	        '~\[bximg class=(.*?) src=(.*?)\]~s'

	    );

	// HTML tags to replace BBcode
	    $replace = array(
	        '<strong>$1</strong>',
	        '<i>$1</i>',
	        '<span style="text-decoration:underline;">$1</span>',
	        '<pre>$1</pre>',
	        '<span style="font-size:$1px;">$2</span>',
	        '<span style="color:$1;">$2</span>',
	        '<a href="$1">$1</a>',
	        '<img src="$1" class="img-responsive" alt="" />',
	        '<img src="$1" class="img-responsive" alt="" />',
	        '<img src="" class="js-auto" data-src="$1" alt="" />',
	        '<img src="" class="js-auto-responsive" data-src="$1" class="img-responsive" alt="" />',

	        '<a href="$1" class="$2">$3</a>',
	        '<span class="label label-default $1">$2</span>',
	        '<div class="alert alert-default $1">$2</div>',

	        '<div class="panel-body">$1</div>',
	        '<div class="panel-heading">$1</div>',
	        '<div class="panel panel-default">$1</div>',
	        '<div class="panel panel-default $1">$2</div>',

	        '<li role="presentation" class="active"><a href="#$1" aria-controls="$1" role="tab" data-toggle="tab">$2</a></li>',
	        '<li role="presentation"><a href="#$1" aria-controls="$1" role="tab" data-toggle="tab">$2</a></li>',
	        '<ul class="nav nav-tabs" role="tablist">$1</ul>',
	        '<div role="tabpanel" class="tab-pane active" id="$1">$2</div>',
	        '<div role="tabpanel" class="tab-pane" id="$1">$2</div>',
	        '<div class="tab-content">$1</div>',
	        '<div role="tabpanel">$1</div>',

	        '<div class="row">$1</div>',
	        '<div class="row $1">$2</div>',
	        '<div class="row" id="$1">$2</div>',
	        '<div class="row $1" id="$2">$3</div>',
	        '<div class="row $2" id="$1">$3</div>',

	        '<div class="col-lg-12">$1</div>',
	        '<div class="col-lg-12 $1">$2</div>',
	        '<div class="col-lg-12" id="$1">$2</div>',
	        '<div class="col-lg-12 $1" id="$2">$3</div>',
	        '<div class="col-lg-12 $2" id="$1">$3</div>',

	        '<img class="$1" src="$2" />',

	        '<div class="dropdown">$1</div>',
	        '<button class="btn btn-default $1 dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">$2<span class="caret"></span></button>',
	        '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">$1</ul>',
	        '<li role="presentation"><a role="menuitem" tabindex="-1" href="$1">$2</a></li>',

	        '<ul class="bxslider">$1</ul><script>$(document).ready(function(){$(\'.bxslider\').bxSlider({auto: true});});</script>',
	        '<li><img src="$1" /></li>',
	        '<li><img class="$1" src="$2" /></li>'

	    );

	    $replaces = array(

	        '[unordered_list]' => '<ul>', '[/unordered_list]' => '</ul>',
	        '[list]' => '<ul>', '[/list]' => '</ul>',
	        '[ul]' => '<ul>', '[/ul]' => '</ul>',
	        '[ordered_list]' => '<ol>', '[/ordered_list]' => '</ol>',
	        '[ol]' => '<ol>', '[/ol]' => '</ol>',
	        '[list_item]' => '<li>', '[/list_item]' => '</li>',
	        '[li]' => '<li>', '[/li]' => '</li>',
	        '[*]' => '<li>', '[/*]' => '</li>',
	        '[code]' => '<code>', '[/code]' => '</code>',
	        '[code]' => '<pre>', '[/code]' => '</pre>',
	        '[code]' => '<pre>', '[/code]' => '</pre>',
	        '[heading1]' => '<h1>', '[/heading1]' => '</h1>',
	        '[heading2]' => '<h2>', '[/heading2]' => '</h2>',
	        '[heading3]' => '<h3>', '[/heading3]' => '</h3>',
	        '[h1]' => '<h1>', '[/h1]' => '</h1>',
	        '[h2]' => '<h2>', '[/h2]' => '</h2>',
	        '[h3]' => '<h3>', '[/h3]' => '</h3>',
	        '[p]' => '<p>', '[/p]' => '</p>',
	        '[para]' => '<p>', '[/para]' => '</p>',
	        '[p]' => '<p>', '[/p]' => '</p>',
	        '[p][p]' => '','[p][p][p]' => '','[p][p][p][p]' => '',
	        '[/p][/p]' => '','[/p][/p][/p]' => '','[/p][/p][/p][/p]' => '',
	        '[b]' => '<b>', '[/b]' => '</b>',
	        '[b]' => '<strong>', '[/b]' => '</strong>',
	       	'<newline>'=>"\r\n"


	    );

    	$str = preg_replace($find, $replace, $str);
	    $str = str_replace(array_keys($replaces), array_values($replaces), $str);

	    // $find = array("<br>", "<br/>", "<br />");

	    // $str = str_replace($find, "\r\n", $str);

	    // $str = trim(strip_tags($str));

	    return $str;		
	}

	public function toBBcode($str)
	{
		$str=trim($str);
	// HTML tags to replace BBcode
	    $regex = array(
	        '/<img class="(.*?)" src="(.*?)" \/>/i'=>'[img class=(.*?)]$2[/img]',
	        '/<div class="col-lg-12 (.*?)" id="(.*?)">(.*?)<\/div>/i'=>'[col id=$2 class=$1]$3[/col]',
	        '/<div class="col-lg-12 (.*?)" id="(.*?)">(.*?)<\/div>/i'=>'[col class=$1 id=$2]$3[/col]',
	        '/<div class="col-lg-12" id="(.*?)">(.*?)<\/div>/i'=>'[col id=$1]$2[/col]',
	        '/<div class="col-lg-12 (.*?)">(.*?)<\/div>/i'=>'[col class=$1]$2[/col]',
	        '/<div class="col-lg-12">(.*?)<\/div>/i'=>'[col]$1[/col]',

	        '/<div class="row (.*?)" id="(.*?)">(.*?)<\/div>/i'=>'[row id=$2 class=$1]$3[/row]',
	        '/<div class="row" id="(.*?)">(.*?)<\/div>/i'=>'[row id=$1]$2[/row]',
	        '/<div class="row (.*?)">(.*?)<\/div>/i'=>'[row class=$1]$2[/row]',
	        '/<div class="row">(.*?)<\/div>/i'=>'[row]$1[/row]',

	        '/<div role="tabpanel">(.*?)<\/div>/i'=>'[tab]$1[/tab]',
	        '/<div class="tab-content">(.*?)<\/div>/i'=>'[tabcontent]$1[/tabcontent]',
	        '/<div role="tabpanel" class="tab-pane" id="(.*?)">(.*?)<\/div>/i'=>'[tabpanel id=$1]$2[/tabpanel]',
	        '/<div role="tabpanel" class="tab-pane active" id="(.*?)">(.*?)<\/div>/i'=>'[tabpanel:active id=$1]$2[/tabpanel]',
	        '/<ul class="nav nav-tabs" role="tablist">(.*?)<\/ul>/i'=>'[navtabs]$1[/navtabs]',
	        '/<li role="presentation"><a href="#(.*?)" aria-controls="(.*?)" role="tab" data-toggle="tab">(.*?)<\/a><\/li>/i'=>'[taburl id=$1]$3[/taburl]',
	        '/<li role="presentation" class="active"><a href="#(.*?)" aria-controls="(.*?)" role="tab" data-toggle="tab">(.*?)<\/a><\/li>/i'=>'[taburl:active id=$1]$3[/taburl]',

	        '/<div class="panel panel-default (.*?)">(.*?)<\/div>/i'=>'[panel class=$1]$2[/panel]',
	        '/<div class="panel panel-default">(.*?)<\/div>/i'=>'[panel]$1[/panel]',
	        '/<div class="panel-heading">(.*?)<\/div>/i'=>'[paneltitle]$1[/paneltitle]',
	        '/<div class="panel-body">(.*?)<\/div>/i'=>'[panelbody]$1[/panelbody]',

	        '/<div class="alert alert-default (.*?)">(.*?)<\/div>/i'=>'[alert class=$1]$2[/alert]',
	        '/<span class="label label-default (.*?)">(.*?)<\/span>/i'=>'[label class=$1]$2[/label]',
	        '/<a href="(.*?)" class="(.*?)">(.*?)<\/a>/i'=>'[url href=$1 class=$2]$3[/url]',

	        '/<img alt="" src="(.*?)" .*? \/>/i'=>'[img]$1[/img]',
	        '/<img alt="(.*?)" src="(.*?)" .*? \/>/i'=>'[img]$2[/img]',
	        '/<img.*? src="(.*?)" .*?>/i'=>'[img]$1[/img]',
	        '/<img.*? src="(.*?)".*?>/i'=>'[img]$1[/img]',
	        '/<img alt src="(.*?)".*?>/i'=>'[img]$1[/img]'

	    );


	    $replaces = array(

	        '[unordered_list]' => '<ul>', '[/unordered_list]' => '</ul>',
	        '[list]' => '<ul>', '[/list]' => '</ul>',
	        '[ul]' => '<ul>', '[/ul]' => '</ul>',
	        '[ordered_list]' => '<ol>', '[/ordered_list]' => '</ol>',
	        '[ol]' => '<ol>', '[/ol]' => '</ol>',
	        '[list_item]' => '<li>', '[/list_item]' => '</li>',
	        '[li]' => '<li>', '[/li]' => '</li>',
	        '[*]' => '<li>', '[/*]' => '</li>',
	        '[code]' => '<code>', '[/code]' => '</code>',
	        '[code]' => '<pre>', '[/code]' => '</pre>',
	        '[code]' => '<pre>', '[/code]' => '</pre>',
	        '[heading1]' => '<h1>', '[/heading1]' => '</h1>',
	        '[heading2]' => '<h2>', '[/heading2]' => '</h2>',
	        '[heading3]' => '<h3>', '[/heading3]' => '</h3>',
	        '[h1]' => '<h1>', '[/h1]' => '</h1>',
	        '[h2]' => '<h2>', '[/h2]' => '</h2>',
	        '[h3]' => '<h3>', '[/h3]' => '</h3>',
	        '[p]' => '<p>', '[/p]' => '</p>',
	        '[para]' => '<p>', '[/para]' => '</p>',
	        '[p]' => '<p>', '[/p]' => '</p>',
	        '' => '<p><p>','' => '</p></p>',
	        '' => '<p><p><p>','' => '</p></p></p>',
	        '' => '<p><p><p><p>','' => '</p></p></p></p>',
	        
	        '[b]' => '<b>', '[/b]' => '</b>',

	        '[b]' => '<strong>', '[/b]' => '</strong>',
	        '' => '<br>', '' => '<br/>',
	        "\r\n"=>'<newline>'
	    );	

    	$str = preg_replace(array_keys($regex), array_values($regex), $str);

	    $str = str_replace(array_values($replaces), array_keys($replaces), $str);

	    return $str;	

	}
}
?>