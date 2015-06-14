<?php

class DBCache
{
	private static $enable='no';

	public function enable()
	{
		self::$enable='yes';
	}

	public function disable()
	{
		self::$enable='no';
	}



	public function get($queryStr='',$timeLive=15)
	{
		// die(self::$enable);
		if(self::$enable=='no' || !isset($queryStr[1]))
		{
			return false;
		}

		$queryStr=md5($queryStr);


		Cache::setPath(CACHES_PATH.'dbcache/');

		if(!$loadData=Cache::loadKey($queryStr,$timeLive))
		{
			return false;
		}

		Cache::setPath(CACHES_PATH);

		self::$enable='no';

		// $loadData=json_decode($loadData,true);
		$loadData=unserialize(base64_decode($loadData));

		return $loadData;
	}

	public function make($keyName,$inputData=array())
	{
		if(self::$enable=='no')
		{
			return false;
		}
		
		$inputData=base64_encode(serialize($inputData));
		// print_r($inputData);
		// die();
		Cache::setPath(CACHES_PATH.'dbcache/');

		Cache::saveKey($keyName,$inputData);

		Cache::setPath(CACHES_PATH);
	}

}

?>