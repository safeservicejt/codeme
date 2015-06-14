
$(document).ready(function(){


	$('.btnNextStep').click(function(){

		$('.panel-1').hide();
		$('.panel-2').slideDown('slow');


	});

	$('.btnSend').click(function(){

		var txtDBName=$('.txtDBName').val();

		var txtDBUser=$('.txtDBUser').val();

		var txtDBPass=$('.txtDBPass').val();

		var txtDBHost=$('.txtDBHost').val();

		var txtDBPort=$('.txtDBPort').val();

		var txtUrl=$('.txtUrl').val();

		var txtPath=$('.txtPath').val();

		var txtUsername=$('.txtUsername').val();

		var txtPassword=$('.txtPassword').val();

		// if(txtDBName.length <= 1)
		// {
		// 	showError('.notifyPanel-2','Enter database name');

		// 	return false;
		// }
		if(txtDBUser.length <= 1)
		{
			showError('.notifyPanel-2','Enter database username');

			return false;
		}
		if(txtDBHost.length <= 1)
		{
			showError('.notifyPanel-2','Enter database host name');

			return false;
		}
		if(txtDBPort.length <= 1)
		{
			showError('.notifyPanel-2','Enter database port');

			return false;
		}
		if(txtUrl.length <= 1)
		{
			showError('.notifyPanel-2','Enter you site url');

			return false;
		}
		if(txtPath.length <= 1)
		{
			showError('.notifyPanel-2','Enter site path');

			return false;
		}
		if(txtUsername.length <= 1)
		{
			showError('.notifyPanel-2','Enter administrator username');

			return false;
		}
		if(txtPassword.length <= 1)
		{
			showError('.notifyPanel-2','Enter administrator password');

			return false;
		}

		$.ajax({
	   type: "POST",
	   url: "./process.php",
	   data: ({
			  do : "connect",
			  dbhost : txtDBHost,
			  dbuser : txtDBUser,
			  dbpass : txtDBPass,
			  dbname : txtDBName,
			  dbport : txtDBPort,
			  url : txtUrl
			  }),
	   dataType: "html",
	   success: function(msg)
						{

						 if(msg.indexOf('ERRORCONNECT')!=-1)
						 {
						 	showError('.notifyPanel-2','Can not connect to database');
						 	return false;
						 }
						 if(msg.indexOf('ERRORURL')!=-1)
						 {
						 	showError('.notifyPanel-2','Your site url not valid');
						 	return false;
						 }

						 if(msg.indexOf('OK')!=-1)
						 {
						 	showSuccess('.notifyPanel-2','Connect to database successful');

						 	$('.btnContinue').fadeIn('slow');
						 }

						 

						 }
			 });		

	});

	$('.btnContinue').click(function(){

		var txtDBName=$('.txtDBName').val();

		var txtDBUser=$('.txtDBUser').val();

		var txtDBPass=$('.txtDBPass').val();

		var txtDBHost=$('.txtDBHost').val();

		var txtDBPort=$('.txtDBPort').val();

		var txtUrl=$('.txtUrl').val();

		var txtPath=$('.txtPath').val();

		var txtUsername=$('.txtUsername').val();

		var txtPassword=$('.txtPassword').val();

		// if(txtDBName.length <= 1)
		// {
		// 	showError('.notifyPanel-2','Enter database name');

		// 	return false;
		// }
		if(txtDBUser.length <= 1)
		{
			showError('.notifyPanel-2','Enter database username');

			return false;
		}
		if(txtDBHost.length <= 1)
		{
			showError('.notifyPanel-2','Enter database host name');

			return false;
		}
		if(txtDBPort.length <= 1)
		{
			showError('.notifyPanel-2','Enter database port');

			return false;
		}
		if(txtUrl.length <= 1)
		{
			showError('.notifyPanel-2','Enter you site url');

			return false;
		}
		if(txtPath.length <= 1)
		{
			showError('.notifyPanel-2','Enter site path');

			return false;
		}
		if(txtUsername.length <= 1)
		{
			showError('.notifyPanel-2','Enter administrator username');

			return false;
		}
		if(txtPassword.length <= 1)
		{
			showError('.notifyPanel-2','Enter administrator password');

			return false;
		}

		$('.wrapper').slideDown('slow');

		$(this).val('Loading...');

		$.ajax({
	   type: "POST",
	   url: "./process.php",
	   data: ({
			  do : "complete",
			  dbhost : txtDBHost,
			  dbuser : txtDBUser,
			  dbpass : txtDBPass,
			  dbname : txtDBName,
			  dbport : txtDBPort,
			  url : txtUrl,
			  path : txtPath,
			  username : txtUsername,
			  password : txtPassword
			  }),
	   dataType: "json",
	   success: function(msg)
						{
						$('.wrapper').slideUp('fast');
							// alert(msg['error']);return false;
						 if(msg['error']=='yes')
						 {
						 	showError('.notifyPanel-2','Can not connect to database');

						 	$(this).val('Complete');

						 	return false;
						 }

						 if(msg['error']=='no')
						 {
						 	$('.showUsername').html(msg['username']);
						 	$('.showPassword').html(msg['password']);

						 	$('.Urlsite').attr('href',msg['siteurl']);
						 	$('.Urlfontend').attr('href',msg['url']);

						 	$('.panel-2').hide();

						 	$('.panel-3').slideDown('slow');
						 }

						 

						 }
			 });			

	});


});


function notify(keyName,message)
{
	$(keyName).html(message);
}

function showError(keyName,message)
{
	var txt='<div class="alert alert-warning">'+message+'</div>';

	notify(keyName,txt);
}
function showSuccess(keyName,message)
{
	var txt='<div class="alert alert-success">'+message+'</div>';

	notify(keyName,txt);
}
