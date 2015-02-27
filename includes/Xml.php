<?php

class Xml
{
	/*
	<songs>
	    <song dateplayed="2011-07-24 19:40:26">
	        <title>I left my heart on Europa</title>
	        <artist>Ship of Nomads</artist>
	    </song>
	    <song dateplayed="2011-07-24 19:27:42">
	        <title>Oh Ganymede</title>
	        <artist>Beefachanga</artist>
	    </song>
	    <song dateplayed="2011-07-24 19:23:50">
	        <title>Kallichore</title>
	        <artist>Jewitt K. Sheppard</artist>
	    </song>
	</songs>

    $mysongs = Xml::fromFile('songs.xml');

    $mysongs->song[1]['dateplayed'];//get attribute
    echo $mysongs->song[0]->artist;
	*/
	public function fromString($inputData)
	{
		if(!isset($inputData[1]))
		{
			return $inputData;
		}

		$resultData=self::parseProcess($inputData);

		return $resultData;
	}

	public function fromFile($inputData)
	{
		if(!file_exists($inputData))
		{
			return false;
		}

		$resultData=file_get_contents($inputData);

		$resultData=self::parseProcess($resultData);

		return $resultData;
	}

	public function fromUrl($inputData)
	{
		$resultData=Http::getDataUrl($inputData);

		$resultData=self::parseProcess($resultData);

		return $resultData;
	}

	private function parseProcess($inputData)
	{
		$inputData=trim($inputData);

		$inputData=simplexml_load_string($inputData);

		return $inputData;
	}
}
?>