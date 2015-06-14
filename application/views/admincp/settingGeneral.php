
<form action="" method="post" enctype="multipart/form-data">	
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">System Setting</h3>
  </div>
  <div class="panel-body">
<div class="row">
		<div class="col-lg-12">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">

		  <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
		  <li class="active"><a href="#info" role="tab" data-toggle="tab">Site information</a></li>
		  <li><a href="#reading" role="tab" data-toggle="tab">Front Page</a></li>

		</ul>

		  
		<!-- Tab panes -->
		<div class="tab-content">

		  <!-- General		 -->		
		  
		  <div class="tab-pane active" id="general">
		  
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>System status :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[system_status]" id="system_status" class="form-control">
							<option value="working">Working</option>
								<option value="underconstruction">Under construction</option>
								<option value="comingsoon">Coming soon</option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>System language :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[system_lang]" id="system_lang" class="form-control">
							<option value="en">English</option>
								<option value="vn">Vietnamese</option>

							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Register user status :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[register_user_status]" id="register_user_status" class="form-control">
							<option value="enable">Enable</option>
								<option value="disable">Disable</option>

							</select>
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Default member user group :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[default_member_groupid]" id="default_member_groupid" class="form-control">
							<?php
								$total=count($usergroups);

								$li='';

								for($i=0;$i<$total;$i++)
								{
									if((int)$default_member_groupid==$usergroups[$i]['groupid'])
									{
										$li.='<option value="'.$usergroups[$i]['groupid'].'" selected>'.$usergroups[$i]['group_title'].'</option>';

									}
									else
									{
										$li.='<option value="'.$usergroups[$i]['groupid'].'">'.$usergroups[$i]['group_title'].'</option>';

									}
								
								}

								echo $li;
							?>
							</select>
			    		</div>

			    	</div>
			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Default banned user group :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[default_member_banned_groupid]" id="default_member_banned_groupid" class="form-control">
							<?php
								$total=count($usergroups);

								$li='';

								for($i=0;$i<$total;$i++)
								{
									if((int)$default_member_banned_groupid==$usergroups[$i]['groupid'])
									{
										$li.='<option value="'.$usergroups[$i]['groupid'].'" selected>'.$usergroups[$i]['group_title'].'</option>';

									}
									else
									{
										$li.='<option value="'.$usergroups[$i]['groupid'].'">'.$usergroups[$i]['group_title'].'</option>';

									}
								
								}

								echo $li;
							?>
							</select>
			    		</div>

			    	</div>

			    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-9">
			    		<strong>Date format :</strong>
			    		</div>
			    		<div class="col-lg-3 text-right">
							<select name="general[default_dateformat]" id="default_dateformat" class="form-control">
							<option value="m/d/Y h:i:s" ><?php echo date('m/d/Y h:i:s');?></option>
							<option value="M d, Y"><?php echo date('M d, Y');?></option>
							<option value="m-d-Y"><?php echo date('m-d-Y');?></option>
							<option value="M d, Y A" ><?php echo date('M d, Y A');?></option>
							<option value="m-d-Y h:i" ><?php echo date('m-d-Y h:i');?></option>
							<option value="M d, Y h:i"><?php echo date('M d, Y h:i');?></option>
							<option value="m-d-Y h:i"><?php echo date('m-d-Y h:i');?></option>
							<option value="M d, Y h:i A" ><?php echo date('M d, Y h:i A');?></option>

							</select>
			    		</div>

			    	</div>
				    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off comment on posts ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[comment_status]" id="comment_status" class="form-control">
							<option value="enable" >Enable</option>
							<option value="disabled" >Disabled</option>
							</select>								
			    		</div>

			    	</div>
				    	<div class="row" style="margin-top:10px;margin-bottom:10px;">
			    		<div class="col-lg-10">
			    		<strong>Turn On/Off RSS feeds ?</strong>
			    		</div>
			    		<div class="col-lg-2 text-right">
							<select name="general[rss_status]" id="rss_status" class="form-control">
							<option value="enable">Enable</option>
							<option value="disabled" >Disabled</option>
							</select>								
			    		</div>

			    	</div>
		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>

		  
		  </div>

		  <!-- General		 -->

		  
		  <div class="tab-pane" id="info">
		  	
		  <p>Title:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Title..." name="general[title]" id="title" value="<?php echo $title;?>" />
		  	</p>
	<p>Description:</p>
  	<p>
		  	<input type="text" class="form-control" placeholder="Description..." name="general[descriptions]" id="descriptions" value="<?php echo $descriptions;?>" />
		  	</p>
	<p>Keywords:</p>		  		  			  
  	<p>
		  	<input type="text" class="form-control" placeholder="Keywords..." name="general[keywords]" id="keywords" value="<?php echo $keywords;?>" />
		  	</p>
		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>
		 
		  </div>


		  <!-- Reading -->
		  
		  <div class="tab-pane" id="reading">
			
		  	<p>
		  		<strong>Default page:</strong>
		  	</p>
		  	<p>
		  		<select class="form-control selectDefault_page" id="default_page_method"  name="general[default_page_method]">
		  		<option value="none">Home</option>
		  		<option value="url">Custom uri</option>
		  		</select>
		  	</p>

		  	<p class="default_page" style="display:none;">
		  	<strong>Post/pageid default:</strong> <br>
		  		<input type="text" class="form-control" name="general[default_page_url]" id="default_page_url" value="<?php echo $default_page_url;?>" placeholder="post/test_post.html" />
		  	</p>

		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>		  	
		 
		  </div>
		  <!-- End Reading -->

		</div>
	
		  

		</div>

	</div>    

  </div>
</div>
</form>
<script>

$(document).ready(function(){

	$('.selectDefault_page').change(function(){

		var thisVal=$(this).val();

		if(thisVal!='home')
		{
			$('.default_page').show();
		}
		else
		{
			$('.default_page').hide();
		}
	});


	setSelect('default_page_method','<?php echo $default_page_method;?>');
	setSelect('rss_status','<?php echo $rss_status;?>');
	setSelect('comment_status','<?php echo $comment_status;?>');
	setSelect('default_dateformat','<?php echo $default_dateformat;?>');
	setSelect('default_member_banned_groupid','<?php echo $default_member_banned_groupid;?>');
	setSelect('default_member_groupid','<?php echo $default_member_groupid;?>');
	setSelect('register_user_status','<?php echo $register_user_status;?>');
	setSelect('system_lang','<?php echo $system_lang;?>');
	setSelect('system_status','<?php echo $system_status;?>');

});

function setSelect(id,value)
{
	$('#'+id+' option').each(function(){
		var thisVal=$(this).val();

		if(thisVal==value)
		{
			$(this).attr('selected',true);
		}


	});
}
</script>