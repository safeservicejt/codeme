

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Add new chapter</h3>
  </div>
  <div class="panel-body">

<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="col-lg-12">

				<?php echo $alert;?>
			</div>		


		<div class="col-lg-12">

			<!-- Add new -->

        <p class="pChosen">
        <div class="row">
        <div class="col-lg-12">
        <label><strong>Choose a manga</strong></label>
        <input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="0" data-method="manga" data-key="jsonManga" placeholder="Type manga name here..." />
                <div class="listAutoSuggest"><ul></ul></div>  
                  <ul class="ulChosen"></ul>
        </div>
        </div>

        </p>      
      <p>
      <label><strong>Title (blank if not):</strong></label>
      <input type="text" name="send[title]" class="form-control" placeholder="Title..." />
      </p>
			<p>
			<label><strong>Chapter number:</strong></label>
			<input type="text" name="send[number]" class="form-control" placeholder="Chapter number..." required />
			</p>
        <p>
        <label><strong>Upload chapter's image:</strong></label>
        <select class="form-control uploadIMGMethod" name="uploadIMGMethod">
          <option value="frompc">From your PC</option>
          <option value="fromurl">From Url</option>
        </select>
        </p>

        <p class="pUploadIMGFromPc" style="display:block;">
        <label><strong>Choose images from pc:</strong></label>
        <input type="file" multiple name="listimg[]" />
        </p>

          <p class="pUploadIMGFromUrl" style="display:none;">
        <label><strong>Or upload from url (separator by new line):</strong></label>
        <textarea rows="10" class="form-control" name="send[content]" placeholder="List images"></textarea>

          <input type="radio" name="send[content_type]" value="host" id="hostRadio" checked /> <label for="hostRadio">Upload</label>
          <input type="radio" name="send[content_type]" value="url" id="urlRadio" /> <label for="urlRadio">Not Upload</label>


        </p>


		</div>
		<div class="col-lg-12">
			<p>
			<button type="submit" class="btn btn-info" name="btnAdd">Add new</button>
			</p>
		</div>		
		</form>


	</div>    
    
  </div>
</div>
  <script type="text/javascript">

			var root_url='<?php echo THIS_URL?>';

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
     url: root_url+keyName,
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

    if(theMethod=='manga')
    {
      newLi+='<input type="hidden" name="send[mangaid]" class="valueChosen" value="'+theID+'" />';
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
