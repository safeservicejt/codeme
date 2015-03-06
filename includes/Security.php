<?php

class Security
{
    public function allowIP($ipStr = '')
    {
        $ipSource = $_SERVER['REMOTE_ADDR'];

        if ($ipSource != $ipStr)
        Alert::make('Page not found');
    }

    public function allowRefer($inputData)
    {
    	$refer=Http::get('refer');

    	$inputData=str_replace('/', '\/', $inputData);

    	if(preg_match('/'.$inputData.'/i', $refer))
    	{
    		Alert::make('Page not found');
    	}
    }
}

?>