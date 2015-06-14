<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit page</h3>
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
                <button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
            </p>  
    	
    	</div>

        <!-- right -->
        <div class="col-lg-4">
     

                <p>
                <label><strong>Page type:</strong></label>
                <select class="form-control" id="postType" name="send[page_type]">
                <option value="normal">Normal</option>
                  <option value="image">Image</option>
                  <option value="fullwidth">Full Width</option>
                  <option value="page">Page</option>
                  <option value="forum">Forum</option>
                  <option value="box">Box</option>

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

            var postType='<?php echo $edit["page_type"];?>';

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
    
  </script>