<?php

class Theme
{

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:10;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$listDir=Dir::listDir(THEMES_PATH);

		$total=count($listDir);

		$result=array();

		for($i=$limitPage;$i<$limitShow;$i++)
		{
			if(!isset($listDir[$i]))
			{
				continue;
			}

			if($listDir[$i]==THEME_NAME)
			{
				continue;
			}
			
			$path=THEMES_PATH.$listDir[$i].'/';
			$url=THEMES_URL.$listDir[$i].'/';


			$result[$listDir[$i]]=file($path.'info.txt');

			$result[$listDir[$i]]['thumbnail']=$url.'thumb.jpg';

		}
		return $result;
		
	}

	public function setActivate($themeName)
	{
		$path=ROOT_PATH.'contents/themes/'.$themeName.'/';

		if(!is_dir($path))
		{
			throw new Exception("This theme not exists");
		}

		$info=$path.'info.txt';

		if(!file_exists($info))
		{
			throw new Exception("This theme not valid.");
		}

		$configPath=ROOT_PATH.'config.php';

		$data=file_get_contents($configPath);

		$data=preg_replace('/"THEME_NAME", \'\w+\'/i', '"THEME_NAME", \''.$themeName.'\'', $data);

		File::create($configPath,$data);

	}

	public function getDefault()
	{
		$path=ROOT_PATH.'contents/themes/'.THEME_NAME.'/';

		$resultData=array();

		$resultData=file($path.'info.txt');

		$resultData['name']=THEME_NAME;

		return $resultData;		
	}

	public function getThemeHeader()
	{
		$data=Plugins::load('site_header');

		return $data;
	}

	public function getThemeFooter()
	{
		$data=Plugins::load('site_footer');

		return $data;
	}

	public function getAdmincpHeader()
	{
		$data=Plugins::load('admincp_header');

		return $data;
	}

	public function getAdmincpFooter()
	{
		$data=Plugins::load('admincp_footer');

		return $data;
	}

	public function getUsercpHeader()
	{
		$data=Plugins::load('usercp_header');

		return $data;
	}

	public function getUsercpFooter()
	{
		$data=Plugins::load('usercp_footer');

		return $data;
	}

    public function loadShortCode()
    {
        $path=System::getThemePath().'shortcode.php';

        if(!file_exists($path))
        {
            return false;
        }

        require($path);

        // try {

        //     require($path);

        // } catch (Exception $e) {

        //     throw new Exception("Error while require functions of theme ".THEME_NAME);

        // }

    }

    public function controller($pageName,$func='index',$otherPath='')
    {
    	$themePath=System::getThemePath().'controller/';

    	if(isset($otherPath[1]))
    	{
    		$themePath=$otherPath;
    	}

    	Controller::loadWithPath('theme'.ucfirst($pageName),$func,$themePath);
    }

    public function model($pageName,$otherPath='')
    {
    	$themePath=System::getThemePath().'model/';

    	if(isset($otherPath[1]))
    	{
    		$themePath=$otherPath;
    	}

    	Model::loadWithPath($pageName,$themePath);
    }

    public function view($pageName,$inputData=array(),$otherPath='')
    {
    	$themePath=System::getThemePath().'view/';
    	
    	if(isset($otherPath[1]))
    	{
    		$themePath=$otherPath;
    	}

    	View::makeWithPath($pageName,$inputData,$themePath);
    }

	public function remove($themeName)
	{

	}


}
?>