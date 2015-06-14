<script src="<?php echo ROOT_URL; ?>bootstrap/ckeditor/ckeditor.js"></script>
  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/admincp/css/chosen.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/datepicker/css/datepicker.css">
 	<script src="<?php echo ROOT_URL;?>bootstrap/datepicker/js/bootstrap-datepicker.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add new product</h3>
  </div>
  <div class="panel-body">

<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="col-lg-12">

				<?php echo $alert;?>
			</div>		
			<div class="col-lg-12">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
				  <li role="presentation" class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
				  <li role="presentation"><a href="#data" role="tab" data-toggle="tab">Data</a></li>
				  <!-- <li role="presentation"><a href="#attribute" role="tab" data-toggle="tab">Option</a></li> -->
					<li role="presentation"><a href="#discount" role="tab" data-toggle="tab">Discount</a></li>
					<li role="presentation"><a href="#images" role="tab" data-toggle="tab">Images</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">

				<!-- General -->
				  <div role="tabpanel" class="tab-pane active" id="general">
				  		<!-- row -->
				  		<div class="row">
				  		<!-- left -->
				  		<div class="col-lg-8">
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[title]" class="form-control" placeholder="Post title..." />
			</p>
			<p>
			<label><strong>Content:</strong></label>
			<textarea id="editor1" class="form-control ckeditor" rows="20" name="send[content]">Content here (support BBCode)</textarea>
			</p>
			<p>
			<label><strong>Reward points:</strong></label>
			<input type="text" name="send[points]" class="form-control" value="0" placeholder="Reward points..." />
			</p>			
			<p>
			<label><strong>SEO Keywords:</strong></label>
			<input type="text" name="send[keywords]" class="form-control" placeholder="Keywords..." />
			</p>

			<p>
			<label><strong>Tags:</strong></label>
			<input type="text" name="tags" class="form-control" placeholder="Tags..." />
			</p>

				  		</div>
				  		<!-- left -->
				  		
				  		<!-- right -->
				  		<div class="col-lg-4">
				<p class="pChosen">
				<div class="row">
				<div class="col-lg-12">
				<label><strong>Categories</strong></label>
				<input type="text" class="form-control txtAuto" data-maxselect="1000" data-numselected="0" data-method="category" data-key="jsonCategory" placeholder="Type here..." />
	              <div class="listAutoSuggest"><ul></ul></div>	
                  <ul class="ulChosen"></ul>
				</div>
				</div>

				</p>
				<p class="pChosen">
				<div class="row">
				<div class="col-lg-12">
				<label><strong>Manufacturer</strong></label>
				<input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="0" data-method="manufacturer" data-key="jsonManufacturer" placeholder="Type here..." />
	              <div class="listAutoSuggest"><ul></ul></div>	
                  <ul class="ulChosen"></ul>
				</div>
				</div>

				</p>

				<p class="pChosen">
				<div class="row">
				<div class="col-lg-12">
				<label><strong>Downloads</strong></label>
				<input type="text" class="form-control txtAuto" data-maxselect="1000" data-numselected="0" data-method="download" data-key="jsonDownload" placeholder="Type here..." />
	              <div class="listAutoSuggest"><ul></ul></div>	
                  <ul class="ulChosen"></ul>
				</div>
				</div>

				</p>		
							<p>
							<label><strong>Upload thumbnail image:</strong></label>
							<select class="form-control uploadIMGMethod" name="uploadIMGMethod">
								<option value="frompc">From your PC</option>
								<option value="fromurl">From Url</option>
							</select>
							</p>

							<p class="pUploadIMGFromPc" style="display:block;">
							<label><strong>Choose image from pc:</strong></label>
							<input type="file" name="pcThumbnail" />
							</p>

								<p class="pUploadIMGFromUrl" style="display:none;">
							<label><strong>Or upload from url:</strong></label>
							<input type="text" class="form-control" name="urlThumbnail" placeholder="Url..." />
							</p>
												
				  		</div>
				  		<!-- right -->

				  		</div>
				  		<!-- row -->
				  </div>
				<!-- End general -->

				<!-- Data -->
				  <div role="tabpanel" class="tab-pane" id="data">
		<p>
			<label><strong>Model:</strong></label>
			<input type="text" name="send[model]" class="form-control" placeholder="Model name..." />
			</p>
		<p>
			<label><strong>SKU:</strong></label>
			<input type="text" name="send[sku]" class="form-control" placeholder="SKU Code..." />
			</p>
		<p>
			<label><strong>UPC:</strong></label>
			<input type="text" name="send[upc]" class="form-control" placeholder="UPC Code..." />
			</p>

		<p>
			<label><strong>Price:</strong></label>
			<input type="text" name="send[price]" class="form-control" value="0.00" placeholder="Price..." />
			</p>
		<p>
			<label><strong>Quantity:</strong></label>
			<input type="text" name="send[quantity]" class="form-control" value="1" placeholder="Quantity..." />
			</p>
		<p>
			<label><strong>Minimum Quantity: (Force a minimum ordered amount)</strong></label>
			<input type="text" name="send[minimum]" class="form-control" value="1" placeholder="Minimum Quantity..." />
			</p>
		<p>
			<label><strong>Date Available:</strong></label>
			<input type="text" name="send[date_available]" data-provide="datepicker" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" />
			</p>
		<p>
			<label><strong>Require shipping:</strong></label>
			<br>
			<select name="send[is_shipping]" class="form-control">
			<option value="1">Yes</option>
			<option value="0">No</option>
			</select>
			</p>
		<p>
			<label><strong>Status:</strong></label>
			<br>
			<select name="send[status]" class="form-control">
			<option value="1">Publish</option>
			<option value="0">unPublish</option>
			</select>
			</p>

			<script>
			$(document).ready(function(){
				$('.datepicker').datepicker({
					    format: 'yyyy-mm-dd'
					})
			});
			</script>
 
				  </div>
				<!-- End Data -->


				<!-- Attribute -->
<!-- 				  <div role="tabpanel" class="tab-pane" id="attribute">

				  </div> -->
				<!-- End Attribute -->
				<!-- discount -->
				  <div role="tabpanel" class="tab-pane" id="discount">
		<p>
			<label><strong>Quantity:</strong></label>
			<input type="text" name="send[quantity_discount]" class="form-control" value="0" placeholder="Quantity..." />
			</p>
		<p>
			<label><strong>Price:</strong></label>
			<input type="text" name="send[price_discount]" class="form-control" value="0.00" placeholder="Price discount..." />
			</p>
		<p>
			<label><strong>Date start:</strong></label>
			<input type="text" name="send[date_discount]" class="form-control startDiscount" value="<?php echo date('Y-m-d');?>" placeholder="Date start discount..." />
			</p>
		<p>
			<label><strong>Date end:</strong></label>
			<input type="text" name="send[date_enddiscount]" class="form-control endDiscount" value="<?php echo date('Y-m-d');?>" placeholder="Date end discount..." />
			</p>
			<script>
			$(document).ready(function(){
				$('.startDiscount').datepicker({
					    format: 'yyyy-mm-dd'
					});
								$('.endDiscount').datepicker({
					    format: 'yyyy-mm-dd'
					});

			});
			</script>

				  </div>
				<!-- End discount -->
				<!-- images -->
				  <div role="tabpanel" class="tab-pane" id="images">
		<p>
			<label><strong>Select product images:</strong></label>
			<input type="file" name="images[]" multiple />
			</p>
				  </div>
				<!-- End images -->


				</div>				
			</div>		





		<div class="col-lg-12">


			<!-- Add new -->
			<div style="display:block;">

	

			<p>
			<button type="submit" class="btn btn-primary" name="btnAdd">Add new</button>
			</p>
			</div>



		</form>
		</div>




	</div>
    
    
  </div>
</div>
  <script type="text/javascript">

			var root_url='<?php echo ROOT_URL;?>';

           $(document).ready(function(){

           	$('.uploadIMGMethod').change(function(){
           		var thisVal=$(this).val();

           		if(thisVal=='frompc')
           		{
           			$('.pUploadIMGFromPc').show();
            			$('.pUploadIMGFromUrl').hide();
           		}
           		if(thisVal=='fromurl')
           		{
           			$('.pUploadIMGFromPc').hide();
            			$('.pUploadIMGFromUrl').show();
           		}


           	});



           });       

 $( document ).on( "click", "span.removeTextChosen", function() {

  var txtAuto=$(this).parent().parent().parent().children('.txtAuto');

    var theMaxSelect=txtAuto.attr('data-maxselect');

    var theNumSelect=txtAuto.attr('data-numselected');

    theNumSelect=parseInt(theNumSelect)-1;

    txtAuto.attr('data-numselected',theNumSelect);

    if(parseInt(theNumSelect) < parseInt(theMaxSelect))
    {
    	txtAuto.attr('disabled',false);
    }   

  	$(this).parent().remove();
});		          
$( document ).on( "mouseout", "div.listAutoSuggest > ul",function(){
  // $(this).slideUp('fast');
        });  

$( document ).on( "keydown", "input.txtAuto", function() {


  var theValue=$(this).val();

  var listUl=$(this).parent().children('.listAutoSuggest');

  var keyName=$(this).attr('data-key');


  if(theValue.length > 1 )
  {

    $.ajax({
     type: "POST",
     url: root_url+"admincp/products/"+keyName,
     data: ({
        do : "load",
        keyword : theValue
        }),
     dataType: "html",
     success: function(msg)
            {
             // $('#listtenPhuongAuto').html('<ul>'+msg+'</ul>');

             // $('#listtenPhuongAuto').slideDown('fast');
              listUl.html('<ul>'+msg+'</ul>');

            listUl.slideDown('fast');

             }
       });            
  }

});    

$( document ).on( "click", "div.listAutoSuggest > ul > li > span", function() {

    var theValue=$(this).text();

    var theID=$(this).attr('data-id');

    var theMethod=$(this).attr('data-method');

    var txtAuto=$(this).parent().parent().parent().parent().children('.txtAuto');

    txtAuto.val('');

    var theMaxSelect=txtAuto.attr('data-maxselect');

    var theNumSelect=txtAuto.attr('data-numselected');

    var numLi=$(this).parent().parent().parent().parent().children('.ulChosen').children('.li').length;

    if(parseInt(theNumSelect)==0 && parseInt(numLi) == parseInt(theMaxSelect))
    {

    	txtAuto.attr('disabled',true);

    	$(this).parent().parent().parent().slideUp('fast');

    	return false;
    } 

    var newLi='<li><span class="textChosen" >'+theValue+'</span><span title="Remove this" class="removeTextChosen">[x]</span>';

    if(theMethod=='category')
    {
    	newLi+='<input type="hidden" name="send[catid]" class="valueChosen" value="'+theID+'" />';
    }

    if(theMethod=='download')
    {
    	newLi+='<input type="hidden" name="downloadid[]" class="valueChosen" value="'+theID+'" />';
    }
    if(theMethod=='manufacturer')
    {
    	newLi+='<input type="hidden" name="send[manufacturerid]" class="valueChosen" value="'+theID+'" />';
    }

    	newLi+='</li></ul>';

    $(this).parent().parent().parent().parent().children('ul.ulChosen').append(newLi);
    $(this).parent().parent().parent().slideUp('fast');

    theNumSelect=parseInt(theNumSelect)+1;

    txtAuto.attr('data-numselected',theNumSelect);

    if(parseInt(theNumSelect) >= parseInt(theMaxSelect))
    {
    	txtAuto.attr('disabled',true);
    }

});    
  </script>