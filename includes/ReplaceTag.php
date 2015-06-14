<?php

class ReplaceTag
{

	public function make($content,$inputData=array())
	{
		/*
				
		$content=ReplaceTag::make($text,array(
			'nội thất'=>'<a href="http://thietkewebsite.com">Nội thất</a>',
			'thiết kế nội thất'=>'<a href="http://thietkewebsite.com">thiết kế nội thất</a>',

			'ngôn ngữ lập trình'=>'<a href="http://ngnongulapttrinh.com">ngôn ngữ lập trình</a>'

			));

		*/
		krsort($inputData);

		$replaceData=array();

		$keyNames=array_keys($inputData);

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName='/ '.$keyNames[$i].' /i';

			$replaceData[$keyName]=' '.$inputData[$keyNames[$i]].' ';
		}

		// print_r($replaceData);die();

		$content=preg_replace(array_keys($replaceData), array_values($replaceData), $content);



		return $content;
	}

}
?>