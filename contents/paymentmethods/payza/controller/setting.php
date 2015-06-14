<?php

if(!$match=Uri::match('\/setting\/payza\/'))
{
	Redirect::to(ROOT_URL);
}

$post=array('alert'=>'');

Model::load(PAYMENTMETHOD_PATH.'model/setting',1);

if(Request::has('btnSend'))
$post['alert']=settingProcess();

$post['data']=settingData();

View::make(PAYMENTMETHOD_PATH.'view/setting',$post,1);

?>