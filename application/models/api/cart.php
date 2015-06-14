<?php

function loadApi($action)
{
	switch ($action) {

		
		case 'htmlpopupdata':

			$htmlData=Cart::htmlPopupData();

			$data=json_encode(array('data'=>$htmlData));

			return $data;
			
			break;
		
		case 'add_product':

			if(!Request::has(array('productid','quantity')))
			{
				throw new Exception("Product not valid.");
			}
			
			try {

				Cart::addProduct(Request::get('productid'),Request::get('quantity'));

				$data=json_encode(array('error'=>'no','message'=>'Add product success.'));

				return $data;

			} catch (Exception $e) {

				throw new Exception($e->getMessage());
			}
			
			break;

		case 'remove_product':

			if(!Request::has('productid'))
			{
				throw new Exception("Product not valid.");
			}
			
			Cart::removeProduct(Request::get('productid'));

			$data=json_encode(array('error'=>'no','message'=>'Remove product success.'));

			return $data;
			
			break;

		case 'remove_coupon':

			if(!Request::has('code'))
			{
				throw new Exception("Coupon not valid.");
			}
			
			Cart::removeCoupon();

			$data=json_encode(array('error'=>'no','message'=>'Remove coupon success.'));

			return $data;
			
			break;

		case 'remove_voucher':

			if(!Request::has('code'))
			{
				throw new Exception("Voucher not valid.");
			}
			
			Cart::removeVoucher();

			$data=json_encode(array('error'=>'no','message'=>'Remove voucher success.'));

			return $data;
			
			break;
		case 'clear':
			
			Cart::clear();

			$data=json_encode(array('error'=>'no','message'=>'Clear cart success.'));

			return $data;
			
			break;

		case 'add_coupon':

			if(!Request::has('code'))
			{
				throw new Exception("Coupon code not valid.");
			}

			try {

				Cart::addCoupon(Request::get('code'));

				$data=json_encode(array('error'=>'no','message'=>'Add coupon success.'));

				return $data;

			} catch (Exception $e) {

				throw new Exception($e->getMessage());
			}
			
			break;
		case 'add_voucher':

			if(!Request::has('code'))
			{
				throw new Exception("Voucher code not valid.");
			}

			try {

				Cart::addVoucher(Request::get('code'));

				$data=json_encode(array('error'=>'no','message'=>'Add voucher success.'));

				return $data;

			} catch (Exception $e) {

				throw new Exception($e->getMessage());
			}
			
			break;


	}	
}

?>