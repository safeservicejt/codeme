<?php

class Country
{

	public function get()
	{

		$loadData=Cache::loadKey('listCountries',-1);

		$loadData=unserialize($loadData);

		return $loadData;
		
	}

	public function makeSelect()
	{
		$loadData=self::get();

		$total=count($loadData);

		$li='';

		if(isset($loadData[0]['name']))
		for ($i=0; $i < $total; $i++) { 
			$li.='<option value="'.$loadData[$i]['iso_code_2'].'">'.$loadData[$i]['name'].'</option>';
		}

		return $li;
	}


}
?>