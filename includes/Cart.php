<?php

/*
$cart=$_SESSION['cart'];

$cart['products']=array(); //Product id

$cart['discount']['coupon'];

$cart['discount']['voucher'];

$cart['vat']=10;
$cart['vattotal']=10;

$cart['subtotal']

$cart['total']

*/

class Cart
{
	public function api($action)
	{
		Model::load('api/cart');

		try {
			loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	public function isEmpty()
	{
		if(!isset($_SESSION['cart']))
		{
			return true;
		}

		$first=current($_SESSION['cart']);

		if(!$first)
		{
			return true;
		}

		return false;
	}

	public function get()
	{
		if(!isset($_SESSION['cart']))
		{
			return false;
		}

		$cart=$_SESSION['cart'];

		return $cart;
	}

	public function jsonData()
	{
		if(!isset($_SESSION['cart']))
		{
			return false;
		}

		$cart=json_encode($_SESSION['cart']);

		return $cart;
	}

	public function jsonFullData()
	{
		if(!isset($_SESSION['cart']))
		{
			return false;
		}

		$cart=$_SESSION['cart'];

		$totalProd=count($cart['products']);

		if($totalProd > 0)
		{
			$listID=array_keys($cart['products']);

			$tmpListID="'".implode("','", $listID)."'";

			$loadData=Products::get(array(
				'where'=>"where productid IN ($tmpListID)"
				));

			if(isset($loadData[0]['productid']))
			{
				$totalProd=count($loadData);

				for ($i=0; $i < $totalProd; $i++) { 

					$prodid=$loadData[$i]['productid'];

					$quantity=$_SESSION['cart']['products'][$prodid];

					$cart['products'][$prodid]=$loadData[$i];

					$cart['products'][$prodid]['cart']=$quantity;
				}
			}
		}

		return $cart;
	}


	public function htmlPopupData()
	{
		$totalProd=0;

		$loadData=array();

		$trProd='';

		$tableProd='';

		if(!isset($_SESSION['cart']))
		{
			$loadData['total']=0;
		}
		else
		{
			$loadData=self::jsonFullData();

			if(isset($loadData['products']))
			{
				$totalProd=count($loadData['products']);

				if($totalProd > 0)
				{
					self::updateTotal();

					$keyNames=array_keys($loadData['products']);

					for ($i=0; $i < $totalProd; $i++) { 

						$prodid=$keyNames[$i];

						$theItem=$loadData['products'][$prodid];

						$trProd.='

						<tr>
				          <td class="image"> <a href="'.$theItem['url'].'"><img src="'.$theItem['image'].'" alt="'.$theItem['title'].'" title="'.$theItem['title'].'"></a>
				            </td>
				          <td class="name"><a href="'.$theItem['url'].'">'.$theItem['title'].'</a>
				            <div>
				            </div></td>
				          <td class="quantity">x&nbsp;'.$theItem['totalInCart'].'</td>
				          <td class="total">'.$theItem['priceFormat'].'</td>
				          <td class="remove"><img src="'.ROOT_URL.'bootstrap/cart/remove-small.png" id="cartRemoveProd" data-productid="'.$theItem['productid'].'" alt="Remove" title="Remove"></td>
				        </tr>		

						';


					}

					$tableProd='
				 		<div class="mini-cart-info">
					      <table>
					                <tbody>

					                '.$trProd.'

					                </tbody>
					      </table>
					    </div>

					    <div class="mini-cart-total">
					      <table>
					                <tbody>
					                <tr>
					          <td class="right"><b>VAT ('.$loadData['vat'].'%):</b></td>
					          <td class="right">'.$loadData['vattotal'].'</td>
					        </tr>
					                <tr>
					          <td class="right"><b>Total:</b></td>
					          <td class="right">'.$loadData['total'].'</td>
					        </tr>
					              </tbody></table>
					    </div>
					    <div class="checkout"><a href="'.$cartUrl.'">View Cart</a> | <a href="'.$checkoutUrl.'">Checkout</a></div>		    
					';					

					
				}
			}

		}

		$resultData='

		<div id="cart">
		  <div class="heading">
		    <h4>Shopping Cart</h4>
		    <a>
		    <span id="cart-total">'.$totalProd.' item(s) - '.$loadData['total'].'</span>
		    </a>
		  </div>
	  		<div class="content" style="display: none;">
	       '.$tableProd.'
	      	</div>
		</div>

		';

		return $resultData;		
	}

	public function addPaymentMethod($name)
	{
		$name=strtolower($name);
		
		$path=ROOT_PATH.'contents/paymentmethods/'.$name.'/index.php';

		if(!file_exists($path))
		{
			throw new Exception("This payment method not exists.");
		}

		$_SESSION['cart']['payment']=$name;
	}

	public function addProduct($prodid,$quantity=1)
	{
		if((int)$quantity <= 0)
		{
			throw new Exception("Quantity must large than 0.");
			
		}

		if(!isset($_SESSION['cart']))
		{
			$_SESSION['cart']=array();
		}

		$loadData=Products::get(array(
			'where'=>"where productid='$prodid' AND status='1'"
			));

		if(!isset($loadData[0]['productid']))
		{
			throw new Exception("This product not exists.");
		}

		if((int)$loadData[0]['quantity']<=0)
		{
			throw new Exception("This product is out stock.");
		}

		if((int)$quantity < (int)$loadData[0]['minimum'])
		{
			throw new Exception("This product require minimum to add is: ".$loadData[0]['minimum']);
		}



		if(isset($_SESSION['cart']['products'][$prodid]))
		{
			$old=$_SESSION['cart']['products'][$prodid];

			$_SESSION['cart']['products'][$prodid]=(int)$old + (int)$quantity;
		}
		else
		{
			$_SESSION['cart']['products'][$prodid]=$quantity;			
		}
	}

	public function has($prodid)
	{
		if(!isset($_SESSION['cart']['products'][$prodid]))
		{
			return false;
		}

		return true;

	}

	public function addCoupon($code)
	{
		$today=date('Y-m-d');

		$loadData=Coupons::get(array(
			'where'=>"where code='$code' AND status='1' AND DATE(date_end)>='$today'"
			));

		if(isset($loadData[0]['code']))
		{
			$_SESSION['cart']['discount']['coupon']['code']=$code;

			$_SESSION['cart']['discount']['coupon']['amount']=$loadData[0]['amount'];

			$_SESSION['cart']['discount']['coupon']['type']=$loadData[0]['type'];

			$freeshipping=((int)$loadData[0]['freeshipping']==1)?'yes':'no';

			$_SESSION['cart']['discount']['coupon']['freeshipping']=$loadData[0]['freeshipping'];
		}
		else
		{
			throw new Exception("This coupon code not valid.");
			
		}
	}

	public function addVoucher($code)
	{
		$today=date('Y-m-d');

		$loadData=Vouchers::get(array(
			'where'=>"where code='$code' AND status='1'"
			));

		if(isset($loadData[0]['code']))
		{
			$_SESSION['cart']['discount']['voucher']['code']=$code;

			$_SESSION['cart']['discount']['voucher']['amount']=$loadData[0]['amount'];
		}
	}

	public function discountProcess($cartData=array())
	{
		$cartData['discount']=0;		

		$cartData=$_SESSION['cart'];
		
		if(isset($_SESSION['cart']['discount']))
		{
			// print_r(Session::get('discount.voucher'));die();

			if(isset($_SESSION['cart']['discount']['coupon']))
			{
				$coupon=$_SESSION['cart']['discount']['coupon'];

				$totalCoupon=0;

				switch ($coupon['type']) {

					case 'money':

						// $cartData['subtotal']=(double)$cartData['subtotal'] - (double)$coupon['amount'];

						$_SESSION['cart']['discount']['total']=(double)$_SESSION['cart']['discount']['total']+(double)$coupon['amount'];

						break;

					case 'percent':

						$tmp=((double)$cartData['subtotal'] * (double)$coupon['amount'])/100;

						// $cartData['subtotal']=(double)$cartData['subtotal'] - (double)$tmp;

						$_SESSION['cart']['discount']['total']=(double)$_SESSION['cart']['discount']['total']+(double)$tmp;

						// $totalCoupon+=(double)$tmp;

						break;
					
				}

			}


			if(isset($_SESSION['cart']['discount']['voucher']))
			{
				$voucher=$_SESSION['cart']['discount']['voucher'];

				$_SESSION['cart']['discount']['total']=(double)$_SESSION['cart']['discount']['total']+(double)$voucher['amount'];
			}

			if(isset($_SESSION['cart']['discount']['total']))
			{
				$total=$_SESSION['cart']['discount']['total'];

				$_SESSION['cart']['subtotal']=(double)$_SESSION['cart']['subtotal']-(double)$total;
			}

			// $cartData['discount']=Currency::insertPrice($cartData['discount']);

		}

	}

	public function removeProduct($prodid)
	{
		if(isset($_SESSION['cart']['products'][$prodid]))
		unset($_SESSION['cart']['products'][$prodid]);
	}

	public function removeCoupon()
	{
		if(isset($_SESSION['cart']['discount']['coupon']))
		{
			unset($_SESSION['cart']['discount']['coupon']);
		}
	}
	
	public function removeVoucher()
	{
		if(isset($_SESSION['cart']['discount']['voucher']))
		{
			unset($_SESSION['cart']['discount']['voucher']);
		}
	}

	public function updateTotal()
	{
		if(!isset($_SESSION['cart']))
		{
			return false;
		}

		$listID=array_keys($_SESSION['cart']['products']);

		$parseID="'".implode("','",$listID)."'";

		$resultData=Products::get(array(
			'selectFields'=>'productid,title,image,price,friendly_url,date_discount,date_enddiscount,price_discount,quantity_discount',
			'where'=>"where productid in ($parseID)"
			));

		if(isset($resultData[0]['productid']))
		{
			$total=count($resultData);

			$totalCost=0;

			for ($i=0; $i < $total; $i++) { 
				$totalCost=(double)$resultData[$i]['price']+(double)+$totalCost;
			}

			$_SESSION['cart']['subtotal']=$totalCost;

		}

		self::discountProcess();

		$vat=(double)self::theVAT();

		$_SESSION['cart']['vat']=$vat;

		if((double)$vat > 0)
		{
			$tmp=((double)$_SESSION['cart']['subtotal']*(double)$vat)/100;

			$_SESSION['cart']['vattotal']=$tmp;

			$_SESSION['cart']['total']=(double)$_SESSION['cart']['subtotal']-(double)$tmp;
		}
		else
		{
			$_SESSION['cart']['vattotal']=0;

			$_SESSION['cart']['total']=$_SESSION['cart']['subtotal'];
		}
						
	}

	public function data()
	{
		if(!isset($_SESSION['cart']))
		{
			return false;
		}
		
		$resultData=array();

		$totalItem=count($_SESSION['cart']['products']);

		if((int)$totalItem==0)
		{

			return $resultData;
		}

		$listID=array_keys($_SESSION['cart']['products']);

		$parseID="'".implode("','",$listID)."'";

		$resultData=Products::get(array(
			'selectFields'=>'productid,title,image,price,friendly_url,date_discount,date_enddiscount,price_discount,quantity_discount',
			'where'=>"where productid in ($parseID)"
			));

		return $resultData;
	}

	public function clear()
	{
		unset($_SESSION['cart']);

		$_SESSION['cart']=array();
	}


	public function theVAT()
	{
		$vat=System::getVatPercent();

		return $vat;
	}

}

?>