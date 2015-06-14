<?php

function loadApi($action)
{
	switch ($action) {
		
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


	}	
}

?>