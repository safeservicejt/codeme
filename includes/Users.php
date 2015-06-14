<?php

class Users
{

	public function get($inputData=array())
	{

		$limitQuery="";

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage=((int)$limitPage > 0)?$limitPage:0;

		$limitPosition=$limitPage*(int)$limitShow;

		$limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

		$limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

		$field="userid,groupid,username,firstname,lastname,image,email,password,userdata,ip,verify_code,parentid,date_added";

		$selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

		$whereQuery=isset($inputData['where'])?$inputData['where']:'';

		$orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by date_added desc';

		$result=array();
		
		$command="select $selectFields from users $whereQuery";

		$command.=" $orderBy";

		$queryCMD=isset($inputData['query'])?$inputData['query']:$command;

		$queryCMD.=$limitQuery;

		$cache=isset($inputData['cache'])?$inputData['cache']:'yes';
		
		$cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:15;

		if($cache=='yes')
		{
			// Load dbcache

			$loadCache=DBCache::get($queryCMD,$cacheTime);

			if($loadCache!=false)
			{
				return $loadCache;
			}

			// end load			
		}

		// echo $queryCMD;die();


		$query=Database::query($queryCMD);
		
		if(isset(Database::$error[5]))
		{
			return false;
		}
		
		if((int)$query->num_rows > 0)
		{
			while($row=Database::fetch_assoc($query))
			{

				if(isset($row['date_added']))
				$row['date_addedFormat']=Render::dateFormat($row['date_added']);	

											
				$result[]=$row;
			}		
		}
		else
		{
			return false;
		}
		
		// Save dbcache
		DBCache::make(md5($queryCMD),$result);
		// end save


		return $result;
		
	}

	public function api($action)
	{
		Model::load('api/user');

		try {
			loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	public function forgotPassword($email)
	{
		$email=trim($email);

		$loadUser=self::get(array(
			'where'=>"where email='$email'"
			));

		if(!isset($loadUser[0]['userid']))
		{
			throw new Exception("Email not exists in database");
			
		}

		$newPass=String::randText(10);

		self::update($loadUser[0]['userid'],array(
			'password'=>String::encrypt($newPass)
			));

		$replaces=array(
			'{username}'=>$loadUser[0]['username'],
			'{password}'=>$newPass,
			'{email}'=>$loadUser[0]['email'],
			'{firstname}'=>$loadUser[0]['firstname'],
			'{lastname}'=>$loadUser[0]['lastname']
			);

		$subject=System::getMailSetting('forgotSubject');
		$content=System::getMailSetting('forgotContent');

		$listKeys=array_keys($replaces);

		$listValues=array_values($replaces);

		$content=str_replace($listKeys, $listValues, $content);

		Mail::send(array(
			'toEmail'=>$email,
			'toName'=>$loadUser[0]['username'],
			'subject'=>$subject,
			'content'=>$content
			));
	}

	public function makeRegister()
	{
		$valid=Validator::make(array(
			'send.firstname'=>'required|min:1|slashes',
			'send.lastname'=>'required|min:1|slashes',
			'send.username'=>'required|min:1|slashes',
			'send.email'=>'required|email|slashes',
			'send.password'=>'required|min:1|slashes',
			'send.image'=>'slashes'
			));

		if(!$valid)
		{
			throw new Exception("Check your infomartion again!");
		}

		$insertData=Request::get('send');

		if(!$id=Users::insert($insertData))
		{
			throw new Exception("Check your infomartion again, pls!");
		}	

		return $id;
	}

	public function makeLogin($username,$password)
	{
		$_REQUEST['username']=$username;

		$_REQUEST['password']=$password;

		$valid=Validator::make(array(
			'username'=>'min:3|slashes',
			'password'=>'min:3|slashes'
			));

		if(!$valid)
		{
			throw new Exception("Check your login infomartion again, pls!");
			
		}

		$encryptPassword=String::encrypt($password);


		$getData=self::get(array(
			'where'=>"where (username='$username' OR email='$username') AND password='$encryptPassword'"
			));

		if(!isset($getData[0]['userid']))
		{
			throw new Exception("User not exists in system.");
			
		}

		Cookie::make('username',$username,1440*7);

		Cookie::make('password',$encryptPassword,1440*7);

		Cookie::make('firstname',$getData[0]['firstname'],1440*7);

		Cookie::make('lastname',$getData[0]['lastname'],1440*7);

		Session::make('groupid',$getData[0]['groupid']);

		Session::make('userid',$getData[0]['userid']);

	}


	public function hasLogin()
	{
		if(!Cookie::has('username') || !Cookie::has('password') || !isset($_SESSION['groupid']))
		{
			return false;
		}

		$username=Cookie::get('username');

		$password=Cookie::get('password');

		try {

			self::makeLogin($username,$password);

			return true;

		} catch (Exception $e) {

			return false;

		}
	}

	public function logout()
	{
		Cookie::destroy('username');

		Cookie::destroy('password');

		unset($_SESSION['groupid'], $_SESSION['userid']);

		return true;

	}

	public function changePassword($userid,$newPassword='')
	{

		if(!isset($newPassword[1]))
		{
			return false;
		}

		$thisUserid=$_SESSION['userid'];

		$encryptPassword=String::encrypt($newPassword);

		self::update($userid,array(
			'password'=>$encryptPassword
			));

		if($userid==$thisUserid)
		{
			Cookie::make('password',$encryptPassword,1440*7);
		}

	}

	public function upBalance($userid,$money)
	{
		Database::query("update users set balance=balance+$money where userid='$userid'");
	}

	public function downBalance($userid,$money)
	{
		Database::query("update users set balance=balance-$money where userid='$userid'");
	}



	public function changeGroup($userid,$groupid)
	{

		$getData=UserGroups::get(array(
			'where'=>"where groupid='$groupid'"
			));

		if(!isset($getData[0]['groupid']))
		{
			return false;
		}

		self::update($userid,array(
			'groupid'=>$groupid
			));

		return true;
	}

	public function insert($inputData=array())
	{
		// End addons
		// $totalArgs=count($inputData);

		$addMultiAgrs='';

		if(isset($inputData[0]['username']))
		{
		    foreach ($inputData as $theRow) {

				$theRow['date_added']=date('Y-m-d h:i:s');

				$keyNames=array_keys($theRow);

				$insertKeys=implode(',', $keyNames);

				$keyValues=array_values($theRow);

				$insertValues="'".implode("','", $keyValues)."'";

				$addMultiAgrs.="($insertValues), ";

		    }

		    $addMultiAgrs=substr($addMultiAgrs, 0,strlen($addMultiAgrs)-2);
		}
		else
		{
			$inputData['date_added']=date('Y-m-d h:i:s');

			$keyNames=array_keys($inputData);

			$insertKeys=implode(',', $keyNames);

			$keyValues=array_values($inputData);

			$insertValues="'".implode("','", $keyValues)."'";	

			$addMultiAgrs="($insertValues)";	
		}		

		Database::query("insert into users($insertKeys) values".$addMultiAgrs);

		if(!$error=Database::hasError())
		{
			$id=Database::insert_id();

			return $id;	
		}

		return false;
	
	}

	public function remove($post=array(),$whereQuery='',$addWhere='')
	{


		if(is_numeric($post))
		{
			$id=$post;

			unset($post);

			$post=array($id);
		}

		$total=count($post);

		$listID="'".implode("','",$post)."'";

		$whereQuery=isset($whereQuery[5])?$whereQuery:"userid in ($listID)";

		$addWhere=isset($addWhere[5])?$addWhere:"";

		$command="delete from users where $whereQuery $addWhere";

		Database::query($command);	

		return true;
	}

	public function update($listID,$post=array(),$whereQuery='',$addWhere='')
	{

		if(is_numeric($listID))
		{
			$catid=$listID;

			unset($listID);

			$listID=array($catid);
		}

		$listIDs="'".implode("','",$listID)."'";		
				
		$keyNames=array_keys($post);

		$total=count($post);

		$setUpdates='';

		for($i=0;$i<$total;$i++)
		{
			$keyName=$keyNames[$i];
			$setUpdates.="$keyName='$post[$keyName]', ";
		}

		$setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
		
		$whereQuery=isset($whereQuery[5])?$whereQuery:"userid in ($listIDs)";
		
		$addWhere=isset($addWhere[5])?$addWhere:"";

		Database::query("update users set $setUpdates where $whereQuery $addWhere");

		if(!$error=Database::hasError())
		{
			return true;
		}

		return false;
	}


}
?>