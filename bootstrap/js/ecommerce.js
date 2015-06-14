
var root_url='';
var api_url='';

var lang=new Array();


var checkoutStep1_Option='';

$(document).ready(function(){

	root_url=$('#rootUrl').attr('content');

	api_url=root_url+'api/';

	systemLoadLanguage();

	if($('#theCartData').length >= 1)
	{
		cartData();
	}

	$('button#addToCart').click(function(){

		var prodid=$(this).attr('data-productid');

		addToCart(prodid);
	});

	$('button#btnUpdateQuantity').click(function(){

		var prodid=$(this).attr('data-productid');

		var quantity=$(this).parent().children('input[type="text"]').val();

		updateProduct(prodid,quantity);
	});


	$('button#btnRemoveProd').click(function(){

		if(confirm(lang['removeProduct']['alert']))
		{
			var prodid=$(this).attr('data-productid');

			removeProduct(prodid);			
		}	


	});

	// Cart page

	$('input#coupon').click(function(){

		$('div.divCoupon').show();

		$('div.divVoucher').hide();

	});

	$('input#voucher').click(function(){

		$('div.divCoupon').hide();

		$('div.divVoucher').show();

	});

	$('#btnAddCoupon').click(function(){

		var couponCode=$('#discountCode').val();

		$.ajax({
	   type: "POST",
	   url: api_url+'cart/saveCoupon',
	   data: ({
			  coupon : couponCode
			  }),
	   dataType: "html",
	   success: function(msg)
						{

							// alert(msg);return false;
							setSuccess(lang['addCoupon']['success']);
							
							if(msg.indexOf('ERROR') != -1)
							{
							 	setError(lang['addCoupon']['error']);
							}
							else
							{
								location.href=location.href;
							}

				 			toTop();
						 }
			 });

	});

	$('#btnAddVoucher').click(function(){

		var voucherCode=$('#disvoucherCode').val();

		$.ajax({
	   type: "POST",
	   url: api_url+'cart/saveVoucher',
	   data: ({
			  voucher : voucherCode
			  }),
	   dataType: "html",
	   success: function(msg)
						{

							// alert(msg);return false;
							setSuccess(lang['addVoucher']['success']);
							
							if(msg.indexOf('ERROR') != -1)
							{
							 	setError(lang['addVoucher']['error']);
							}
							else
							{
								location.href=location.href;
							}
							
				 			toTop();
						 }
			 });

	});



	// Checkout



	$('input[type="radio"]#register').click(function(){

		checkoutStep1_Option='register';

	});

	$('input[type="radio"]#guest').click(function(){

		checkoutStep1_Option='guest';

	});

	$('button#checkoutStep1').click(function(){

		// alert(checkoutStep1_Option);

		if(checkoutStep1_Option=='register')
		{
			$('#formToRegister').submit();
		}
		else
		{
			$('#stepOne .colPanelBody').slideUp();

			$('#stepAll').slideDown('slow');

		}

	});

	$('#billSameasShipping').click(function(){

		$('.Deliveryinfo').toggle('fast');


	});

	$('input[type="radio"].thePaymentMethod').click(function(){

		var theMethod=$(this).attr('id');

		var theTitle=$(this).attr('title');

		// alert(theMethod);

		$('.requireForm_'+theMethod).slideDown('slow');

		// $.session.set('paymentTitle', theTitle);

		$('#thePaymentTitle').val(theTitle);

	});




	

});

$( document ).on( "click", "img#cartRemoveProd", function() {

	if(confirm(lang['removeProduct']['alert']))
	{
		var prodID=$(this).attr('data-productid');

		$.ajax({
	   type: "POST",
	   url: api_url+'cart/removeProduct',
	   data: ({
			  productid : prodID
			  }),
	   dataType: "html",
	   success: function(msg)
						{
							if(msg.indexOf('ERROR') != -1)
							{
							 	setError(lang['removeProduct']['error']);
							}
							else
							{
								cartData();	
							}
						 }
			 });	
	}	

});	

// Cart click
$( document ).on( "click", "#cart > div.heading > a", function() {

	$('#cart div.content').toggle();

});	





function systemLoadLanguage()
{
							// alert(api_url+'lang/javascript');return;
	$.ajax({
   type: "POST",
   url: api_url+'lang/javascript',
   dataType: "json",
   success: function(msg)
					{
						// alert(msg);return;

						lang=msg;

						// alert(lang['alert']);

					 }
		 });	
}

function addToCart(prodID)
{
	$.ajax({
   type: "POST",
   url: api_url+'cart/addProduct',
   data: ({
		  productid : prodID
		  }),
   dataType: "html",
   success: function(msg)
					{

						// alert(msg);return false;
						setSuccess(lang['addProduct']['success']);
						
						if(msg.indexOf('ERROR') != -1)
						{
						 	setError(lang['addProduct']['error']);
						}

						cartData();

			 			toTop();
					 }
		 });	
}
function updateProduct(prodID,quant)
{
	$.ajax({
   type: "POST",
   url: api_url+'cart/updateProduct',
   data: ({
		  productid : prodID,
		  quantity : quant
		  }),
   dataType: "html",
   success: function(msg)
					{
						// alert(msg);
						// setSuccess('Update product from shopping cart successful!');

						if(msg.indexOf('ERROR') != -1)
						{
						 	setError(lang['updateProduct']['error']);
						}
						else
						{
							refresh();
						}

						cartData();

			 			toTop();
					 }
		 });	
}
function removeProduct(prodID)
{
	$.ajax({
   type: "POST",
   url: api_url+'cart/removeProduct',
   data: ({
		  productid : prodID
		  }),
   dataType: "html",
   success: function(msg)
					{
						// setSuccess('Remove product from shopping cart successful!');

						if(msg.indexOf('ERROR') != -1)
						{
						 	setError(lang['removeProduct']['error']);
						}
						else
						{
							refresh();	
						}

						cartData();

			 			toTop();
					 }
		 });	
}


function clearCart()
{
	$.ajax({
   type: "POST",
   url: api_url+'cart/clearCart',
   data: ({
		  productid : prodID
		  }),
   dataType: "html",
   success: function(msg)
					{
						
					 }
		 });	
}

function cartData()
{
	if($('#theCartData').length == 0)
	{
		return;
	}	

	$.ajax({
   type: "POST",
   url: api_url+'cart/htmlData',
   dataType: "html",
   success: function(msg)
					{
						// alert(msg);return;
						$('#theCartData').html(msg);
					 }
		 });	
}

function toTop()
{
	$('html, body').animate({ scrollTop: 0 }, 'slow'); 
}

function setSuccess(str)
{
	$('#cmsnotify').html('<div class="alert alert-success">'+str+'</div>');
}

function setError(str)
{
	$('#cmsnotify').html('<div class="alert alert-warning">'+str+'</div>');
}


function refresh()
{
	location.href=location.href;
}