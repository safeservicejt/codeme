<?php

class System
{
	public static $newUri='';

	public static $changeUri='no';

	public static $setting=array();

	public static $adminTitle='Cpanel Noblesse CMS';

	public function before_system_start()
	{
		/*
		Load all setting, site info, site status

		if Uri=admincp : Load plugin caches in admincp

		if Uri=usercp : Load plugin caches in usercp

		if Uri='' : Load plugin caches in frontend


		*/

		self::checkCurrency();

		self::checkLang();

		self::$setting=self::getSetting();

		PluginsZone::loadCache();
		// self::systemStatus();

		self::defaultPageUri();

		Database::connect();

		self::visitorStatus();

		self::userStatus();
		
	}

	public function checkLang()
	{
		if($match=Uri::match('^lang\/(\w+)'))
		{
			$curName=$match[1];
			Lang::set($curName);

			header("Location: ".self::getUrl());

		}

	}
	
	public function checkCurrency()
	{
		if($match=Uri::match('^currency\/(\w+)'))
		{
			$curName=$match[1];
			Currency::set($curName);

			header("Location: ".self::getUrl());

		}

	}

	public function systemStatus()
	{
		$status=self::getStatus();

		switch ($status) {
			case 'underconstruction':
				Alert::make('Website under construction. We will comeback soon...');
				break;
			case 'comingsoon':
				Alert::make('We will comming soon...');
				break;
			
		}
	}

	public function userStatus()
	{
		if(isset($_SESSION['groupid']))
		{
			UserGroups::loadGroup($_SESSION['groupid']);
		}
		
	}
	
	public function visitorStatus()
	{

	}
	public function defaultPageUri()
	{
		$method=self::$setting['default_page_method'];

		if($method=='url' && (!isset($_GET['load']) || !isset($_GET['load'][1])))
		{
			self::setUri(self::$setting['default_page_url']);
		}
	}

	public function after_system_start()
	{

	}

	public function setTitle($title)
	{
		self::$setting['title']=$title;
	}
	
	public function setDescriptions($title)
	{
		self::$setting['descriptions']=$title;
	}

	public function setKeywords($title)
	{
		self::$setting['keywords']=$title;
	}

	public function getTitle()
	{
		return self::$setting['title'];
	}

	public function getDescriptions()
	{
		return self::$setting['descriptions'];
	}

	public function getKeywords()
	{
		return self::$setting['keywords'];
	}

	public function getStatus()
	{
		return self::$setting['system_status'];
	}

	public function getLang()
	{
		$sysLang=self::$setting['system_lang'];

		$sysLang=isset($_SESSION['locale'])?$_SESSION['locale']:$sysLang;

		return $sysLang;
	}

	public function getRegisterStatus()
	{
		return self::$setting['register_user_status'];
	}

	public function getMemberGroupId()
	{
		return self::$setting['default_member_groupid'];
	}

	public function getMemberBannedGroupId()
	{
		return self::$setting['default_member_banned_groupid'];
	}

	public function getDateFormat()
	{
		return self::$setting['default_dateformat'];
	}

	public function getCommentStatus()
	{
		return self::$setting['comment_status'];
	}

	public function getRssStatus()
	{
		return self::$setting['rss_status'];
	}
	
	public function getAffiliateCommission()
	{
		return self::$setting['default_affiliate_commission'];
	}

	public function getVatPercent()
	{
		return self::$setting['default_vat_commission'];
	}

	public function getOrderStatus()
	{
		return self::$setting['default_order_status'];
	}

	public function getCurrency()
	{
		$current=self::$setting['currency'];

		$data=isset($_COOKIE['currency'])?$_COOKIE['currency']:$current;
		
		return $data;
	}

	public function getUrl()
	{
		$url=isset($_SESSION['root_url'])?$_SESSION['root_url']:ROOT_URL;

		return $url;
	}

	public function getThemeUrl()
	{
		$url=self::getUrl().'contents/themes/'.self::getThemeName().'/';

		return $url;
	}

	public function getThemeName()
	{
		$url=isset($_SESSION['theme_name'])?$_SESSION['theme_name']:THEME_NAME;

		return $url;
	}

	public function getThemePath()
	{
		$url=ROOT_PATH.'contents/themes/'.self::getThemeName().'/';

		return $url;
	}

	public function getUri()
	{
        global $cmsUri;

        if(self::$changeUri=='yes')
        {
        	$cmsUri=self::$newUri;
        }

        return $cmsUri;		
	}



	public function setUri($uri)
	{
        self::$changeUri='yes';

        self::$newUri=$uri;	
	}

	public function getMailSetting($keyName)
	{
		$data=self::$setting;

		if(!isset($data['mail'][$keyName]))
		{
			return false;
		}

		return $data['mail'][$keyName];
	}

	public function getSetting()
	{
		if(!$data=Cache::loadKey('systemSetting',-1))
		{
			$data=self::makeSetting();
		}
		else
		{
			$data=unserialize($data);
		}

		return $data;
	}

	public function makeSetting()
	{
		$settingData=array(
			'system_status'=>'working', 'system_lang'=>'en', 'register_user_status'=>'enable',
			'default_member_groupid'=>'1', 'default_member_banned_groupid'=>'2', 'default_dateformat'=>'M d, Y',
			'rss_status'=>'enable','comment_status'=>'enable', 'title'=>'Noblesse CMS Website', 'keywords'=>'noblessecms, blog, website',
			'descriptions'=>'Noblesse CMS Website Description','default_page_method'=>'none','default_page_url'=>'',
			'mail'=>array(
				'send_method'=>'local',
				'fromName'=>'Admin','fromEmail'=>'Admin@gmail.com','smtpAddress'=>'smtp.gmail.com',
				'smtpUser'=>'youremail@gmail.com','smtpPass'=>'yourpass','smtpPort'=>'497',
				'registerSubject'=>'Signup completed - NoblesseCMS','registerContent'=>'Content here','forgotSubject'=>'Subject here',
				'forgotContent'=>'Content here'
				),
			'default_affiliate_commission'=>'50','default_vat_commission'=>'10','default_order_status'=>'pending','default_currency'=>'usd','default_min_withdraw'=>'10'
			);	

		Cache::saveKey('systemSetting',serialize($settingData));

		return $settingData;
	}

	public function saveSetting($inputData=array())
	{
		$data=self::getSetting();

		$keyNames=array_keys($inputData);

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyNames[$i];

			$data[$keyName]=$inputData[$keyName];

		}
		
		Cache::saveKey('systemSetting',serialize($data));
	}

	

	public function saveMailSetting($inputData=array())
	{
		$data=self::getSetting();

		$keyNames=array_keys($inputData);

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyNames[$i];

			$data['mail'][$keyName]=$inputData[$keyName];

		}
		
		Cache::saveKey('systemSetting',serialize($data));
	}




}

?>