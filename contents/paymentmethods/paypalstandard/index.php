<?php

Paymentmethods::$load['title']='Paypal Standard';

Paymentmethods::$load['setting']='setting_ppstandard';

Paymentmethods::install('install_ppstandard');

function install_ppstandard()
{

	Paymentmethods::$load['after_click_confirm_check_out']='after_click_confirm_check_out_ppstandard';

}


function setting_ppstandard()
{
	include(PAYMENTMETHOD_PATH.'controller/setting.php');
}

function after_click_confirm_check_out_ppstandard($orderData=array())
{
	if(!$loadData=Paymentmethods::loadSetting('ppstandard'))
	{
		return false;
	}



	$resultData=array(

		'status'=>'process_page',

		'content'=>''

		);

	$completedUrl=isset($orderData['completedUrl'])?$orderData['completedUrl']:ROOT_URL.'payment/completed';

	$cancelUrl=isset($orderData['cancelUrl'])?$orderData['cancelUrl']:ROOT_URL.'payment/cancel';

	$notifyUrl=isset($orderData['notifyUrl'])?$orderData['notifyUrl']:ROOT_URL.'payment/verify/paypalstandard';

	$content='
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_cart" />
  <input type="hidden" name="upload" value="1" />
  <input type="hidden" name="business" value="'.$loadData['email'].'" />	
  <input type="hidden" name="currency_code" value="USD" />
  <input type="hidden" name="invoice" value="'.$orderData['orderid'].'" />
  <input type="hidden" value="'.$loadData['total'].'" name="amount">
  <input type="hidden" name="lc" value="USA" />
  <input type="hidden" name="rm" value="2" />
  <input type="hidden" name="no_note" value="1" />
  <input type="hidden" name="no_shipping" value="1" />
  <input type="hidden" name="charset" value="utf-8" />
  <input type="hidden" name="return" value="'.$completedUrl.'" />
  <input type="hidden" name="notify_url" value="'.$notifyUrl.'" />
  <input type="hidden" name="cancel_return" value="'.$cancelUrl.'" />
  <input type="hidden" name="paymentaction" value="authorization" />
  <input type="hidden" name="custom" value="'.$orderData['orderid'].'" />
  <input type="hidden" name="bn" value="Noblesse_CMS" />
  <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="Click to pay!" class="btn btn-primary" />
    </div>
  </div>
</form>
	';

	$resultData['content']=$content;

	return $resultData;
}


function verifyPayment_paypalstandard()
{
	$orderid=Request::get('custom',0);

	$status=Request::get('payment_status','cancel');

	$status=strtolower($status);

	$updateData=array('order_status'=>'cancel');

	if($status=='completed')
	{
		$updateData['order_status']='completed';
	}

	Orders::update($orderid,$updateData);


}

?>