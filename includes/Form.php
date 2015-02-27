<?php

class Form
{
	public function open($inputData=array())
	{
		$inputData['attr']['action']=isset($inputData['attr']['action'])?$inputData['attr']['action']:'';


		$inputData['attr']['method']=isset($inputData['attr']['method'])?$inputData['attr']['method']:'post';


		$inputData['attr']['enctype']=insset($inputData['attr']['enctype'])?$inputData['attr']['enctype']:'multipart/form-data';

		$attr=self::attr($inputData);

		$result="<form $attr >";

		return $result;
	}

	public function close()
	{
		$result='</form>';

		return $result;
	}

	public function button($text='button',$inputData=array())
	{
		$inputData['attr']['type']=isset($inputData['attr']['type'])?$inputData['attr']['type']:'button';

		$attr=self::attr($inputData);

		$result="<button $attr >$text</button>";

		return $result;
	}
	public function submit($text='button',$inputData=array())
	{
		$inputData['attr']['type']=isset($inputData['attr']['type'])?$inputData['attr']['type']:'submit';

		$attr=self::attr($inputData);

		$result="<button $attr >$text</button>";

		return $result;
	}

	public function text($inputData=array())
	{
		$inputData['attr']=$inputData;
		
		$inputData['attr']['type']='text';

		$result=self::nonElement('input',$inputData);

		return $result;
	}
	public function email($inputData=array())
	{
		$inputData['attr']=$inputData;

		$inputData['attr']['type']='email';

		$result=self::nonElement('input',$inputData);

		return $result;
	}
	public function password($inputData=array())
	{
		$inputData['attr']=$inputData;

		$inputData['attr']['type']='password';

		$result=self::nonElement('input',$inputData);

		return $result;
	}

	public function select($inputData=array())
	{
		$attr=self::attr($inputData);

		$listOP='';

		if(isset($inputData['data']))
		{
			$total=count($inputData['data']);

			if($total > 0)
			{
				$keyNames=array_keys($inputData['data']);

				for($i=0;$i<$total;$i++)
				{
					$keyName=$keyNames[$i];

					$listOP.="\r\n".'<option value="'.$keyName.'">'.$inputData['data'][$keyName].'</option>';
				}
			}
		}

		$result="<select $attr>$listOP</select>";

		return $result;
	}



	private function attr($inputData=array())
	{
		$attr='';		

		if(isset($inputData['attr']))
		{
			$keyNames=array_keys($inputData['attr']);

			$total=count($inputData['attr']);

			for($i=0;$i<$total;$i++)
			{
				$keyName=$keyNames[$i];
				$attr.=$keyName.'="'.$inputData['attr'][$keyName].'" ';
			}		
		}

		return $attr;
	}

	private function element($tagName='',$tagValue='',$inputData=array())
	{
		$attr=self::attr($inputData);

		$result="<$tagName $attr >$tagValue</$tagName>";

		return $result;
	}


	private function nonElement($tagName='',$inputData=array())
	{
		// print_r($inputData);die();
		$attr=self::attr($inputData);

		$result="<$tagName $attr />";

		return $result;
	}


}

?>