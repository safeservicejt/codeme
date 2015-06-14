<?php

class Checkout
{
	private static $load=array();

	// Array have: error, message, status
	public static $order=array();

	public function tax()
	{
		$listTax=Taxrate::thisIP();

		Session::make('tax_rate',$listTax['tax_rate']);

		Session::make('tax_type',$listTax['tax_type']);

		self::$load['tax_rate']=$listTax['tax_rate'];

		self::$load['tax_type']=$listTax['tax_type'];

		return $listTax;
	}

	public function total()
	{
		$loadData=array();

		if(!function_exists('jsonData'))
		{
			Model::load('api/cart');				
		}

		$content=jsonData();

		$loadData=json_decode($content,true);	

		$tax_rate=self::$load['tax_rate'];

		$tax_type=self::$load['tax_type'];

		$loadData['subtotal']=$loadData['total'];

		$loadData['tax_rate']=$tax_rate;

		// if($tax_type=='fixedamount')
		// {
		// 	// $getData=Currency::parsePrice($tax_rate);

		// 	// $loadData['tax_rate']=$getData['real'];
		// 	// $loadData['tax_rateFormat']=$getData['format'];	

		// 	$loadData['tax_rate']=$tax_rate;

		// }
		// echo $loadData['tax_rate'];die();

		if($tax_type=='percent')
		{
			$loadData['total_tax']=(((double)$loadData['total']*(double)self::$load['tax_rate'])/100);				
		}
		else
		{
			$loadData['total_tax']=(double)self::$load['tax_rate'];			
		}

		$loadData['total']=(double)$loadData['total'] + (double)$loadData['total_tax'];

		return $loadData;
	}


	public function processCheckout()
	{
		$paymentProcess=array();		

		if(!isset($_SESSION['tax_rate']))
		{
			self::$order['error']='yes';

			self::$order['message']=Lang::get('frontend/checkout.process@notvalid');

			$paymentProcess['status']='error';

			$paymentProcess['error']=self::$order['message'];

			return $paymentProcess;
		}

		if(Request::has('agreeTerms')==false)
		{
			self::$order['error']='yes';

			self::$order['message']=Lang::get('frontend/checkout.process@mustagree');

			$paymentProcess['status']='error';

			$paymentProcess['error']=self::$order['message'];

			return $paymentProcess;
		}

		if(Request::has('paymentMethod')==false)
		{
			self::$order['error']='yes';

			self::$order['message']=Lang::get('frontend/checkout.process@rqmethod');

			$paymentProcess['status']='error';

			$paymentProcess['error']=self::$order['message'];

			return $paymentProcess;
		}

		if(!function_exists('jsonData'))
		{
			Model::load('api/cart');				
		}

		$paymentMethod=Request::get('paymentMethod');

		self::$load['tax_rate']=$_SESSION['tax_rate'];

		self::$load['tax_type']=$_SESSION['tax_type'];

		$loadData=self::total();

		if((double)$loadData['total'] < 0)
		{
			self::$order['error']='yes';

			self::$order['message']='Order not valid !';

			$paymentProcess['status']='error';

			$paymentProcess['error']=self::$order['message'];

			return $paymentProcess;
		}

		$loadData=self::insertOrder($loadData);

		self::discountRemove();

		// print_r($loadData);die();

		if(!$loadData)
		{
			$paymentProcess=array('status'=>'error','error'=>self::$order['message']);

			return $paymentProcess;
		}

		$orderid=$loadData['orderid'];

		// $loadData['orderid']=$orderid;

		// $paymentStatus='completed';

		$getData=Currency::parsePrice($loadData['total']);

		

		$loadData['total']='';

		$loadData['total']=$getData['real'];

		$loadData['totalFormat']=$getData['format'];

		$paymentProcess=Paymentmethods::load('after_click_confirm_check_out',$paymentMethod,$loadData);

		if(!isset($paymentProcess['status']))
		{
			$paymentProcess['status']='completed';		
		}

		if($paymentProcess['status']=='process_page')
		{
			Session::make('orderNodeid',$loadData['orderNodeid']);

		}

		if(!isset($paymentProcess['error']))
		{
			$paymentProcess['error']='';
		}


		// print_r($paymentProcess);die();

		return $paymentProcess;
	}

	public function discountRemove()
	{
		if(isset($_SESSION['discount']['coupon']))
		{
			Coupons::remove($_SESSION['discount']['coupon']);
		}
		
		if(isset($_SESSION['discount']['voucher']))
		{
			// Vouchers::remove($_SESSION['discount']['voucher']);

			$total=count($_SESSION['discount']['voucher']);

			for($i=0;$i<$total;$i++)
			{
				$voucher=$_SESSION['discount']['voucher'][$i];

				if(isset($voucher['balance']))
				{
					$balance=$voucher['balance'];

					Vouchers::update($voucher['voucherid'],array(
						'amount'=>$voucher['balance']
						));
				}
			}
		}

	}

	public function insertOrder($orderData=array())
	{

		// print_r($orderData);die();
		
		$insertData=array();
		// $insertData=$orderData;

		$billing=Request::get('billing');

		$shipping=Request::get('shipping');

		$valid=Validator::make(array(
			'billing.firstname'=>'required|min:1|slashes',
			'billing.lastname'=>'required|min:1|slashes',
			'billing.email'=>'required|min:1|email|slashes',
			'billing.phone'=>'required|min:1|slashes',
			'billing.fax'=>'slashes',
			'billing.company'=>'slashes',
			'billing.address_1'=>'required|min:5|slashes',
			'billing.address_2'=>'slashes',
			'billing.city'=>'required|min:1|slashes',
			'billing.postcode'=>'required|min:1|slashes',
			'billing.country'=>'required|min:1|slashes',
			'shipping.firstname'=>'slashes',
			'shipping.lastname'=>'slashes',
			'shipping.phone'=>'slashes',
			'shipping.fax'=>'slashes',
			'shipping.company'=>'slashes',
			'shipping.address_1'=>'slashes',
			'shipping.city'=>'slashes',
			'shipping.postcode'=>'slashes',
			'shipping.country'=>'slashes'

			));

		// print_r($billing);die();

		if(!$valid)
		{
			self::$order['message']=Lang::get('frontend/checkout.process@infonotvalid');

			return false;
		}

		$userid=Session::get('userid');

		$insertData['customerid']=$userid;

		$user=array();

		if(!$userid)
		{
			$insertData['customerid']=0;
		}

		$paymentTitle=Request::get('thePaymentTitle','None');

		$insertData['payment_method']=$paymentTitle;

		$insertData['payment_firstname']=$billing['firstname'];
		$insertData['payment_lastname']=$billing['lastname'];
		$insertData['payment_company']=$billing['company'];
		$insertData['payment_address_1']=$billing['address_1'];
		$insertData['payment_address_2']=$billing['address_2'];
		$insertData['payment_city']=$billing['city'];
		$insertData['payment_postcode']=$billing['postcode'];
		$insertData['payment_country']=$billing['country'];
		$insertData['payment_phone']=$billing['phone'];
		$insertData['payment_fax']=$billing['fax'];
		$insertData['payment_email']=$billing['email'];

		$insertData['shipping_firstname']=$shipping['firstname'];
		$insertData['shipping_lastname']=$shipping['lastname'];
		$insertData['shipping_company']=$shipping['company'];
		$insertData['shipping_address_1']=$shipping['address_1'];
		$insertData['shipping_address_2']=$shipping['address_2'];
		$insertData['shipping_city']=$shipping['city'];
		$insertData['shipping_postcode']=$shipping['postcode'];
		$insertData['shipping_country']=$shipping['country'];	

		$insertData['shipping_phone']=$shipping['phone'];		
		$insertData['shipping_fax']=$shipping['fax'];		

		if(Request::has('billSameasShipping'))
		{
			$insertData['shipping_firstname']=$billing['firstname'];
			$insertData['shipping_lastname']=$billing['lastname'];
			$insertData['shipping_company']=$billing['company'];
			$insertData['shipping_address_1']=$billing['address_1'];
			$insertData['shipping_address_2']=$billing['address_2'];
			$insertData['shipping_city']=$billing['city'];
			$insertData['shipping_postcode']=$billing['postcode'];
			$insertData['shipping_country']=$billing['country'];
		}

		$insertData['comment']=Request::get('commentsOrder');

		$insertData['tax_rate']=$orderData['total_tax'];

		$insertData['vat_rate']=$orderData['totalvat'];

		$insertData['total']=$orderData['total'];

		$insertData['total_products']=count($orderData['items']);

		$insertData['ip']=$_SERVER['REMOTE_ADDR'];

		$insertData['date_added']=date('Y-m-d h:i:s');

		$insertData['date_modified']=date('Y-m-d h:i:s');

		$insertData['order_status']='pending';

		$orderid=Orders::insert($insertData);

		if(!$orderid)
		{
			self::$order['message']='Order not valid !';
			return false;
		}

		for($i = 0;$i < (int)$insertData['total_products'];$i++)
		{
			$item=$orderData['items'][$i];

			$productid=$item['productid'];

			$downloads=array();

			// $loadDownloads=Downloads::get(array(
			// 	'where'=>"where productNodeid='$productNodeid'"
			// 	));

			// if(isset($loadDownloads[0]['productNodeid']))
			// {
			// 	$total=count($loadDownloads);

			// 	for($i=0;$i<$total;$i++)
			// 	{
			// 		$downloadid=$row['downloadNodeid'];

			// 		$downloads[$downloadid]['remaining']=999999;
			// 		$downloads[$downloadid]['downloaded']=0;					
			// 	}
			// }

			$addProd=array(
				'orderid'=>$orderid,
				'productid'=>$item['productid'],
				'quantity'=>$item['totalInCart'],
				'downloads'=>json_encode($downloads),
				'price'=>$item['totalPrice']
				);

			Orders::insertProducts($addProd);

			Orders::insertAffiliate($orderid);
		}

		$insertData['orderid']=$orderid;
		
		$insertData['items']=$orderData['items'];

		return $insertData;
	}



}
?>