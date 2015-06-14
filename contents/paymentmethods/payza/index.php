<?php

Paymentmethods::$load['title']='Payza';

Paymentmethods::$load['setting']='setting_payza';

Paymentmethods::install('install_payza');

function install_payza()
{

	Paymentmethods::$load['after_click_confirm_check_out']='after_click_confirm_check_out_payza';

}


function setting_payza()
{
	// die(PAYMENTMETHOD_PATH);
	include(PAYMENTMETHOD_PATH.'controller/setting.php');
}

function after_click_confirm_check_out_payza($orderData=array())
{
	if(!$loadData=Paymentmethods::loadSetting('payza'))
	{
		return false;
	}



	$resultData=array(

		'status'=>'process_page',

		'content'=>''

		);

	$content='
<form action="https://secure.payza.com/checkout" method="post">
  <input type="hidden" name="ap_merchant" value="<?php echo $ap_merchant; ?>" />
  <input type="hidden" name="ap_amount" value="<?php echo $ap_amount; ?>" />
  <input type="hidden" name="ap_currency" value="USD" />
  <input type="hidden" name="ap_purchasetype" value="Item" />
  <input type="hidden" name="ap_itemname" value="Payza payment" />
  <input type="hidden" name="ap_itemcode" value="'.$orderData['orderid'].'" />
  <input type="hidden" name="ap_returnurl" value="'.ROOT_URL.'payment/completed" />
  <input type="hidden" name="ap_cancelurl" value="'.ROOT_URL.'payment/cancel" />
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


function verifyPayment_payza()
{
	$loadData=Paymentmethods::loadSetting('payza');

	$ap_securitycode=Request::get('ap_securitycode','');

	if(!isset($ap_securitycode[1]))
	{
		return false;
	}

	if($ap_securitycode!=$loadData['secret'])
	{
		$orderid=Request::get('ap_itemcode','0');
		
		Orders::update($orderid,array('order_status'=>'cancel'));
	}

}

?>