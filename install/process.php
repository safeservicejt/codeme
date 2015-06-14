<?php
ob_start();
error_reporting(0);
session_start();

include('../includes/Request.php');
include('../includes/String.php');

include('import.php');

if(!isset($_REQUEST['do']))
{
	die('Hi you !');
}

$do=$_REQUEST['do'];

switch ($do) {
	case 'connect':
	
		checkConnect();

		break;
	case 'complete':

		startInstall();

		break;
	

}

function startInstall()
{
  $dbhost=trim($_REQUEST['dbhost']);

  $dbuser=trim($_REQUEST['dbuser']);

  $dbpass=trim($_REQUEST['dbpass']);

  $dbname=isset($_REQUEST['dbname'])?trim($_REQUEST['dbname']):'';

  $dbport=trim($_REQUEST['dbport']);

  $url=trim($_REQUEST['url']);
  
  $path=trim($_REQUEST['path']);
  
  $username=trim($_REQUEST['username']);
  
  $password=md5(trim($_REQUEST['password']));

  $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbport);	

  if(isset($conn->connect_error[5]))
  {
  	echo json_encode(array('error'=>'yes'));
  	die();
  }

  if(!isset($dbname[1]))
  {
    $dbname='noblessecms_db'.String::randText(5);

    $conn->query("CREATE DATABASE $dbname CHARACTER SET utf8 COLLATE utf8_general_ci;");
    $conn->query("GRANT ALL ON $dbname.* TO '$dbuser'@localhost IDENTIFIED BY '$dbpass';");
    $conn->query("FLUSH PRIVILEGES;");

    if(isset($conn->connect_error[5]))
    {
      echo json_encode(array('error'=>'yes'));
      die();     
    }

    $conn->select_db($dbname);

  }

  $rootPath=dirname(dirname(__FILE__)).'/';

  $loadData=file_get_contents($rootPath.'config.php');

  $replace=array(
    '/"dbhost" \=\> "\w+"/i'=>'"dbhost" => "'.$dbhost.'"',
    '/"dbuser" \=\> "\w+"/i'=>'"dbuser" => "'.$dbuser.'"',
    '/"dbpassword" \=\> ""/i'=>'"dbpassword" => "'.$dbpass.'"',
    '/"dbname" \=\> "\w+"/i'=>'"dbname" => "'.$dbname.'"',
    '/"dbport" \=\> "\w+"/i'=>'"dbport" => "'.$dbport.'"',
   '/root_path = \'.*?\';/i'=>'root_path = \''.$path.'\';',
   '/root_url = \'.*?\';/i'=>'root_url = \''.$url.'\';',

    );

  $loadData=preg_replace(array_keys($replace), array_values($replace), $loadData);

  $fp=fopen($rootPath.'config.php','w');

  fwrite($fp,$loadData);

  fclose($fp);

  import($conn,'db.sql');

  $ip=$_SERVER['REMOTE_ADDR'];

  $date_added=date('Y-m-d h:i:s');

  $query=$conn->query("insert into users(groupid,email,password,ip,date_added,is_admin) values('1','$username','$password','$ip','$date_added','1')");
   
  if(isset($conn->error[5]))
  {
    echo json_encode(array('error'=>'yes'));
    die();    
  }

  rename('../install','../installBackup');
  
	$result['username']=Request::get('username');
	$result['password']=Request::get('password');
	$result['siteurl']=Request::get('url').'admincp/';
  $result['Urlfontend']=Request::get('url');
	$result['error']='no';

	echo json_encode($result);
  die();
}
function checkConnect()
{
  $dbhost=trim($_REQUEST['dbhost']);

  $dbuser=trim($_REQUEST['dbuser']);

  $dbpass=trim($_REQUEST['dbpass']);

  $dbname=trim($_REQUEST['dbname']);

  $dbport=trim($_REQUEST['dbport']);

  $url=trim($_REQUEST['url']);  

  if(!file_get_contents($url.'install/css/custom.css'))
  {
    die('ERRORURL');    
  }

  $conn = new mysqli($dbhost, $dbuser, $dbpass, '', $dbport);	

  if(isset($conn->connect_error[5]))
  {
  	die('ERRORCONNECT');
  }

  die('OK');
}

?>