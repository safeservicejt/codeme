<?php

class Lang
{

	private static $lang=array();

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

		$langPath=LANG_PATH.$dirName.'/';

		$loadData=self::parseName($keyName);

		$fileName=$loadData['fileName'];

		$fieldName=$loadData['fieldName'];



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

		if(!isset($lang) || !isset($lang[$fieldName]))
		{
			Alert::make('The field '.ucfirst($fieldName).' not exists inside language '.ucfirst($fileName));

			return false;			
		}

		$totalAddons=count($addOns);

		if($totalAddons > 0)
		{
			$keyNames=array_keys($addOns);

			for($i=0;$i<$totalAddons;$i++)
			{
				$keyName=$keyNames[$i];

				$lang[$keyName]=$addOns[$keyName];
			}
		}

		self::$totalRow=count($lang);

		if($fieldName=='')
		{
			return $lang;
		}

		return $lang[$fieldName];

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

		if(!preg_match('/(.*?)\.(\w+)/i', $keyName,$matches))
		{
			$fileName=$keyName;

			$fieldName='';

		}
		else
		{

			$fileName=$matches[1];

			$fieldName=$matches[2];			
		}

		$resultData['fileName']=$fileName;

		$resultData['fieldName']=$fieldName;				

		return $resultData;

	}
}

?>