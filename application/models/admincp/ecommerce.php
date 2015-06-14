<?php

function countStats()
{
	$resultData=array();

	$today=date('Y-m-d');

	$loadData=Orders::get(array(
		'query'=>"select count(orderid)as totalcount from orders"
		));

	$resultData['orders']['total']=$loadData[0]['totalcount'];
	
	$loadData=Orders::get(array(
		'query'=>"select count(orderid)as totalcount from orders where DATE(date_added)='$today'"
		));

	$resultData['orders']['today']=$loadData[0]['totalcount'];
	
	$loadData=Orders::get(array(
		'query'=>"select count(orderid)as totalcount from orders where DATE(date_added)='$today' AND status='completed'"
		));

	$resultData['orders']['today_completed']=$loadData[0]['totalcount'];
	
	$loadData=Orders::get(array(
		'query'=>"select count(orderid)as totalcount from orders where status='pending'"
		));

	$resultData['orders']['pending']=$loadData[0]['totalcount'];

	$loadData=Orders::get(array(
		'query'=>"select count(orderid)as totalcount from orders where status='holding'"
		));

	$resultData['orders']['holding']=$loadData[0]['totalcount'];

	$loadData=Orders::get(array(
		'query'=>"select count(orderid)as totalcount from orders where status='cancelled'"
		));

	$resultData['orders']['cancelled']=$loadData[0]['totalcount'];

	$loadData=Orders::get(array(
		'query'=>"select count(orderid)as totalcount from orders where status='completed'"
		));

	$resultData['orders']['completed']=$loadData[0]['totalcount'];

	$loadData=Products::get(array(
		'query'=>"select count(productid)as totalcount from products"
		));

	$resultData['products']['total']=$loadData[0]['totalcount'];
	
	$loadData=Products::get(array(
		'query'=>"select count(productid)as totalcount from products where DATE(date_added)='$today'"
		));

	$resultData['products']['today']=$loadData[0]['totalcount'];
	
	$loadData=Products::get(array(
		'query'=>"select count(productid)as totalcount from products where status='1'"
		));

	$resultData['products']['published']=$loadData[0]['totalcount'];
	
	$loadData=Products::get(array(
		'query'=>"select count(productid)as totalcount from products where status='0'"
		));

	$resultData['products']['pending']=$loadData[0]['totalcount'];

	$loadData=Reviews::get(array(
		'query'=>"select count(reviewid)as totalcount from reviews"
		));

	$resultData['reviews']['total']=$loadData[0]['totalcount'];

	$loadData=Reviews::get(array(
		'query'=>"select count(reviewid)as totalcount from reviews where DATE(date_added)='$today'"
		));

	$resultData['reviews']['today']=$loadData[0]['totalcount'];

	$loadData=Reviews::get(array(
		'query'=>"select count(reviewid)as totalcount from reviews where status='1'"
		));

	$resultData['reviews']['approved']=$loadData[0]['totalcount'];

	$loadData=Reviews::get(array(
		'query'=>"select count(reviewid)as totalcount from reviews where status='0'"
		));

	$resultData['reviews']['pending']=$loadData[0]['totalcount'];

	$loadData=Vouchers::get(array(
		'query'=>"select count(voucherid)as totalcount from vouchers"
		));

	$resultData['vouchers']['total']=$loadData[0]['totalcount'];

	$loadData=Vouchers::get(array(
		'query'=>"select count(voucherid)as totalcount from vouchers where DATE(date_added)='$today'"
		));

	$resultData['vouchers']['today']=$loadData[0]['totalcount'];

	$loadData=Vouchers::get(array(
		'query'=>"select count(voucherid)as totalcount from vouchers where status='0'"
		));

	$resultData['vouchers']['pending']=$loadData[0]['totalcount'];

	$loadData=Coupons::get(array(
		'query'=>"select count(couponid)as totalcount from coupons"
		));

	$resultData['coupons']['total']=$loadData[0]['totalcount'];

	$loadData=Coupons::get(array(
		'query'=>"select count(couponid)as totalcount from coupons where DATE(date_added)='$today'"
		));

	$resultData['coupons']['today']=$loadData[0]['totalcount'];

	$loadData=Coupons::get(array(
		'query'=>"select count(couponid)as totalcount from coupons where status='0'"
		));

	$resultData['coupons']['pending']=$loadData[0]['totalcount'];

	return $resultData;
}

?>