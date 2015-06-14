<script src="<?php echo ROOT_URL; ?>bootstrap/ckeditor/ckeditor.js"></script>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit manga '<?php echo $edit['title'];?>'</h3>
  </div>
  <div class="panel-body">

<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="col-lg-12">

				<?php echo $alert;?>
			</div>		


		<div class="col-lg-8">


			<!-- Add new -->
			<p>
			<label><strong>Title:</strong></label>
			<input type="text" name="send[title]" value="<?php echo $edit['title'];?>" class="form-control" placeholder="Title..." />
			</p>
			<p>
			<label><strong>Summary:</strong></label>
			<textarea id="editor1" class="form-control ckeditor" rows="15" name="send[summary]"><?php echo $edit['summary'];?></textarea>
			</p>
			<p>
			<label><strong>SEO Keywords:</strong></label>
			<input type="text" name="send[keywords]" class="form-control" value="<?php echo $edit['keywords'];?>" placeholder="Keywords..." />
			</p>

			<p>
			<label><strong>Tags: (separate by commas)</strong></label>
			<input type="text" name="tags" class="form-control" value="<?php echo $tags;?>" placeholder="Tags..." />
			</p>



		</div>

		<!-- Right -->
		<div class="col-lg-4">
			<div class="row">
			<div class="col-lg-12">

        <p class="pChosen">
        <div class="row">
        <div class="col-lg-12">
        <label><strong>Categories</strong></label>
        <input type="text" class="form-control txtAuto" data-maxselect="10" data-numselected="0" data-method="category" data-key="get_list_category" placeholder="Type here..." />
                <div class="listAutoSuggest"><ul></ul></div>  
                  <ul class="ulChosen">
                  <?php if(isset($edit['listCat'])){

                    $total=count($edit['listCat']);

                    $li='';

                    if(isset($edit['listCat'][0]['cattitle']))
                    for ($i=0; $i < $total; $i++) { 
                      
                      $li.='
                      <li>
                      <span class="textChosen">'.$edit['listCat'][$i]['cattitle'].'</span>
                      <span title="Remove this" class="removeTextChosen">[x]</span>
                      <input type="hidden" name="catid[]" class="valueChosen" value="'.$edit['listCat'][$i]['catid'].'">
                      </li> 
                      ';
                    }

                    echo $li;

                  }
                  ?>                   

                  </ul>
        </div>
        </div>

        </p>
				<p class="pChosen">
				<div class="row">
				<div class="col-lg-12">
				<label><strong>Author</strong></label>
				<input type="text" autocomplete="off" class="form-control txtAuto" data-maxselect="1" name="author_name" data-numselected="0" data-method="author" data-key="get_list_author" placeholder="Type here..." />
	              <div class="listAutoSuggest"><ul></ul></div>	
                  <ul class="ulChosen">
                  <?php if(isset($edit['author_title'])){ ?>
                  <li>
                  <span class="textChosen"><?php echo $edit['author_title'];?></span>
                  <span title="Remove this" class="removeTextChosen">[x]</span>
                  <input type="hidden" name="authorid" class="valueChosen" value="<?php echo $edit['authorid'];?>">
                  </li>    
                <?php } ?>                    
                  </ul>
				</div>
				</div>

				</p>

			</div>
			<div class="col-lg-12">

				<p>
				<label><strong>Upload preview image:</strong></label>
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

        <?php if(isset($edit['image'][5]))echo '<img src="'.$edit['imageUrl'].'" class="img-responsive" />' ;?>

			</div>

			</div>
		</div>
		<!-- end right -->
		<div class="col-lg-12">
			<p>
			<input type="hidden" name="send[status]" value="1" />
			<button type="submit" class="btn btn-info" name="btnSave">Save changes</button>
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
     url: api_url+keyName,
     data: ({
        do : "load",
        keyword : theValue
        }),
     dataType: "json",
     success: function(msg)
            {

              // alert(msg);return false;
                  
                 if(msg['error']=='no')
                 {
                    listUl.html('<ul>'+msg['data']+'</ul>');

                  listUl.slideDown('fast');              
                 }


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

    if(theMethod=='author')
    {
      newLi+='<input type="hidden" name="authorid" class="valueChosen" value="'+theID+'" />';
    }
    if(theMethod=='category')
    {
    	newLi+='<input type="hidden" name="catid[]" class="valueChosen" value="'+theID+'" />';
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
