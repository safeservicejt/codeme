<?php

Paymentmethods::$load['title']='Moneybookers';

Paymentmethods::$load['setting']='setting_moneybookers';

Paymentmethods::install('install_moneybookers');

function install_moneybookers()
{

	// Paymentmethods::$load['require_form_on_checkout']='require_form_cashondelivery';

	Paymentmethods::$load['after_click_confirm_check_out']='after_click_confirm_check_out_moneybookers';

}


function setting_moneybookers()
{
	include(PAYMENTMETHOD_PATH.'controller/setting.php');
}

function after_click_confirm_check_out_moneybookers($orderData=array())
{
	if(!$loadData=Paymentmethods::loadSetting('moneybookers'))
	{
		return false;
	}



	$resultData=array(

		'status'=>'process_page',

		'content'=>''

		);

	$content='
	<form action="https://www.moneybookers.com/app/payment.pl" method="post">
	  <input type="hidden" name="pay_to_email" value="'.$loadData['email'].'" />
	  <input type="hidden" name="recipient_description" value="Moneybookers Payment" />
	  <input type="hidden" name="transaction_id" value="'.$orderData['orderid'].'" />
	  <input type="hidden" name="return_url" value="'.ROOT_URL.'payment/completed" />
	  <input type="hidden" name="cancel_url" value="'.ROOT_URL.'payment/cancel" />
	  <input type="hidden" name="status_url" value="'.ROOT_URL.'payment/verify/moneybookers" />
	  <input type="hidden" name="language" value="EN" />
	  <input type="hidden" name="amount" value="'.$loadData['total'].'" />
	  <input type="hidden" name="currency" value="USD" />
		  <input type="hidden" name="detail1_description" value="Moneybookers Payment"/>
		  <input type="hidden" name="detail1_text" value="Orderid '.$orderData['orderid'].'"/>
	  <input type="hidden" name="merchant_fields" value="order_id" />
	  <input type="hidden" name="order_id" value="'.$orderData['orderid'].'" />
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


function verifyPayment_moneybookers()
{
	$status=Request::get('status',2);

	if((int)$status==2)
	{
		$text=Request::get('detail1_text','');

		if(!isset($text[1]))
		{
			return false;
		}

		preg_match('/(\d+)/', $text,$match);

		Orders::update($match[1],array('order_status'=>'cancel'));
	}
}

?>