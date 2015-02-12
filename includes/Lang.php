<?php

class Lang
{

	private static $lang=array();

	public static $data=array();

	private static $totalRow=0;

	public function get($keyName,$addOns=array())
	{
		if(!isset($keyName[1]))
		{
			return false;
		}

		$dirName=App::get('locale');

		$fileName='';

		$fieldName='';

		$childName='';

		$langPath=LANG_PATH.$dirName.'/';

		$loadData=self::parseName($keyName);

		$fileName=$loadData['fileName'];

		$fieldName=$loadData['fieldName'];

		if(isset($loadData['childName']))
		{
			$childName=$loadData['childName'];
		}

		if(!isset(self::$data[$fileName]))
		{
			$langPath=$langPath.$fileName.'.php';

			if(!file_exists($langPath))
			{
				Alert::make('Language '.ucfirst($fileName).' not exists in system.');

				return false;
			}


			if((int)self::$totalRow == 0)
			{
				include($langPath);		
					
				// return self::$lang;
			}

			if(!isset($lang))
			{
				Alert::make('The language '.ucfirst($lang).' not exists inside system.');

				return false;			
			}		

			if(isset($fieldName[1]) && !isset($lang[$fieldName]))
			{
				Alert::make('The field '.ucfirst($fieldName).' not exists inside language '.ucfirst($fileName));

				return false;			
			}		

			self::$data[$fileName]=$lang;	
		}
		else
		{
			$lang=self::$data[$fileName];
		}

		self::$totalRow=count($lang);

		if($fieldName=='')
		{
			return $lang;
		}

		$totalAddons=count($addOns);

		if($totalAddons > 0 && !is_array($lang[$fieldName]))
		{
			$keyNames=array_keys($addOns);

			for($i=0;$i<$totalAddons;$i++)
			{
				// $keyName=$keyNames[$i];

				$keyNames[$i]=':'.$keyNames[$i];

				// $lang[$keyName]=$addOns[$keyName];
			}

			$lang[$fieldName]=str_replace(array_keys($addOns), array_values($addOns), $lang[$fieldName]);
		}

		$theText=isset($childName[1])?$lang[$fieldName][$childName]:$lang[$fieldName];

		return $theText;

	}

	public function loadLang($lang)
	{
		if($matches=Uri::match('^language\/([a-zA-Z]+)$'))
		{
			$lang=strtolower(trim($matches[1]));

			$_SESSION['locale']=$lang;

			Redirect::to(ROOT_URL);
		}

		$lang=isset($_SESSION['locale'])?$_SESSION['locale']:$lang;

		App::setLocale($lang);
	}

	public function has($keyName)
	{
		$dirName=App::get('locale');

		$fileName='';

		$fieldName='';

		$langPath=LANG_PATH.$dirName.'/';

		if((int)self::$totalRow == 0)
		{


			$loadData=self::parseName($keyName);

			$fileName=$loadData['fileName'];

			$fieldName=$loadData['fieldName'];

			$langPath.=$fileName.'.php';

			if(!file_exists($langPath))
			{	
				return false;
			}
		
			include($langPath);	

			if(!isset($lang))
			{
				return false;
			}

			self::$lang=$lang;

			self::$totalRow=count($lang);
		}

		if(!isset(self::$lang[$fieldName]))
		{
			return false;
		}	

		return true;
	}

	public function choice($keyName,$theLine=0)
	{
		$loadData='';

		if(self::has($keyName))
		{
			$loadData= self::get($keyName);

			if(is_array($loadData) || !preg_match('/\|/i', $loadData))
			{
				return false;
			}

			$parse=explode('|', $loadData);

			if(!isset($parse[$theLine]))
			{
				return false;
			}

			return $parse[$theLine];
		}

		return false;
	}

	public function parseName($keyName)
	{
		$resultData=array();

		$fileName='';

		$fieldName='';

		$childName='';

		if(!preg_match('/(.*?)\.(\w+)/i', $keyName,$matches))
		{
			$fileName=$keyName;

			$fieldName='';

		}
		else
		{
			if(preg_match('/(\w+)\@(\w+)/i', $keyName,$matchChild))
			{
				$childName=$matchChild[2];
			}

			$fileName=$matches[1];

			$fieldName=$matches[2];			
		}

		$resultData['fileName']=$fileName;

		$resultData['fieldName']=$fieldName;	

		$resultData['childName']=$childName;			

		return $resultData;

	}
}

?>