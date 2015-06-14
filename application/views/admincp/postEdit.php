<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit post</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    <form action="" method="post" enctype="multipart/form-data">
    	<div class="col-lg-8">
    	
        <?php echo $alert;?>
            <p>
                <label><strong>Title</strong></label>
                <input type="text" class="form-control" name="send[title]" value="<?php echo $edit['title'];?>" placeholder="Title" />
            </p>
 
            <p>
                <label><strong>Content</strong></label>
                <textarea id="editor1" rows="15" name="send[content]" class="form-control ckeditor"><?php echo $edit['content'];?></textarea>
            </p>
            <p>
                <label><strong>Keywords</strong></label>
                <input type="text" class="form-control" name="send[keywords]" value="<?php echo $edit['keywords'];?>" placeholder="Keywords" />
            </p> 
            <p>
                <label><strong>Tags (separate by commas)</strong></label>
                <input type="text" class="form-control" name="tags" value="<?php echo $tags;?>" placeholder="Tags" />
            </p>
            <p>
                <button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
            </p>  
    	
    	</div>

        <!-- right -->
        <div class="col-lg-4">
     
                <p class="pChosen">
                <div class="row">
                <div class="col-lg-12">
                <label><strong>Category</strong></label>
                <input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="1" data-method="category" data-key="jsonCategory" placeholder="Type here..." />

                  <div class="listAutoSuggest"><ul></ul></div>  
                  <ul class="ulChosen">
                  <?php if(isset($edit['cattitle'])){ ?>
                  <li>
                  <span class="textChosen"><?php echo $edit['cattitle'];?></span>
                  <span title="Remove this" class="removeTextChosen">[x]</span>
                  <input type="hidden" name="send[catid]" class="valueChosen" value="<?php echo $edit['catid'];?>">
                  </li>    
                <?php } ?>                    

                  </ul>
                </div>
                </div>

                </p> 
                <p>
                <label><strong>Post type:</strong></label>
                <select class="form-control" id="postType" name="send[type]">
                <option value="normal">Normal</option>
                  <option value="image">Image</option>
                  <option value="fullwidth">Full Width</option>
                  <option value="news">News</option>
                  <option value="post">Post</option>
                  <option value="thread">Thread</option>
                  <option value="notify">Notify</option>

                </select>
                </p>
                <p>
                <label><strong>Allow Comment:</strong></label>
                <select class="form-control" id="allowComment" name="send[allowcomment]">
                <option value="1">Yes</option>
                  <option value="0">No</option>

                </select>
                </p>
                <p>
                <label><strong>Publish:</strong></label>
                <select class="form-control" id="postStatus" name="send[status]">
                <option value="1">Yes</option>
                  <option value="0">No</option>

                </select>
                </p>

                <p>
                <label><strong>Upload Thumbnail</strong></label>
                <select class="form-control" name="uploadMethod" id="uploadMethod">
                <option value="frompc" data-target="uploadFromPC">From your pc</option>
                  <option value="fromurl" data-target="uploadFromUrl">From url</option>
                </select>

                </p>

             <p class="pupload uploadFromPC">
                <label><strong>Choose a image</strong></label>
                <input type="file" class="form-control" name="imageFromPC" />
            </p>     
             <p class="pupload uploadFromUrl" style="display:none;">
                <label><strong>Type image url</strong></label>
                <input type="text" class="form-control" name="imageFromUrl" placeholder="Type image url" />
            </p>     

            <p>
              <img src="<?php echo ROOT_URL.$edit['image'];?>" class="img-responsive" />
            </p>
                          
        </div>
        <!-- right -->
    </form>	
    </div>
  </div>
</div>
<script src="<?php echo ROOT_URL; ?>bootstrap/ckeditor/ckeditor.js"></script>

  <script type="text/javascript">
            var root_url='<?php echo ROOT_URL;?>';

            var postType='<?php echo $edit["type"];?>';

            var allowComment='<?php echo $edit["allowcomment"];?>';

            var postStatus='<?php echo $edit["status"];?>';



$(document).ready(function(){
    $('#uploadMethod').change(function(){
        var option=$(this).children('option:selected');

        var target=option.attr('data-target');

        $('.pupload').hide();
        $('.'+target).slideDown('fast');

    });


    $('select#postType option').each(function(){
      var thisVal=$(this).val();

      if(thisVal==postType)
      {
        $(this).attr('selected',true);
      }

    });
    $('select#postStatus option').each(function(){
      var thisVal=$(this).val();

      if(thisVal==postStatus)
      {
        $(this).attr('selected',true);
      }

    });
    $('select#allowComment option').each(function(){
      var thisVal=$(this).val();

      if(thisVal==allowComment)
      {
        $(this).attr('selected',true);
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

$( document ).on( "keydown", "input.txtAuto", function() {


  var theValue=$(this).val();

  var listUl=$(this).parent();

  var keyName=$(this).attr('data-key');

  var targetID=$(this).attr('data-targetID');

  if(theValue.length > 1 )
  {

    $.ajax({
     type: "POST",
     url: root_url+"admincp/categories/"+keyName,
     data: ({
        do : "load",
        keyword : theValue
        }),
     dataType: "html",
     success: function(msg)
            {
             // $('#listtenPhuongAuto').html('<ul>'+msg+'</ul>');

             // $('#listtenPhuongAuto').slideDown('fast');

             if(listUl.children('.listAutoSuggest').length == 0)
             {
                listUl.append('<div class="listAutoSuggest"></div>');
             }


            listUl.children('.listAutoSuggest').html('<ul>'+msg+'</ul>').slideDown('fast');

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