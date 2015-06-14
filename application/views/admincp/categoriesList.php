<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Categories list</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-8">
    	<form action="" method="post" enctype="multipart/form-data">
    		<!-- row -->
    		<div class="row">
    			<div class="col-lg-4">
                    <div class="input-group input-group-sm">
                        <select class="form-control" name="action">
                            <option value="delete">Delete</option>
                        </select>
                       <span class="input-group-btn">
                        <button class="btn btn-primary" name="btnAction" type="submit">Apply</button>
                      </span>

                    </div><!-- /input-group -->   				
    			</div>
    			<div class="col-lg-4 col-lg-offset-4 text-right">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="txtKeywords" placeholder="Search..." />
                       <span class="input-group-btn">
                        <button class="btn btn-primary" name="btnSearch" type="submit">Search</button>
                      </span>

                    </div><!-- /input-group -->       				
    			</div>

    		</div>
    		<!-- row -->
     		<!-- row -->
    		<div class="row">
    			<div class="col-lg-12 table-responsive">
    				<table class="table table-hover">
    					<thead>
    						<tr>
    							<td class="col-lg-1"><input type="checkbox" id="selectAll" /></td>
    							<td class="col-lg-9">Title</td>
    							<td class="col-lg-2">Sort order</td>
    							<td class="col-lg-2">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['catid']))
    						for ($i=0; $i < $total; $i++) { 
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['catid'].'" />
	    							</td>
	    							<td class="col-lg-9">'.$theList[$i]['title'].'</td>
	    							<td class="col-lg-2 text-right">'.$theList[$i]['sort_order'].'</td>
	    							<td class="col-lg-2 text-right">
	    							<a href="'.ADMINCP_URL.'categories/edit/'.$theList[$i]['catid'].'" class="btn btn-warning btn-xs">Edit</a>
	    							</td>
	    						</tr>    						
	    						<!-- tr -->
    							';
    						}

    						echo $li;
    					?>

    					</tbody>
    				</table>
    			</div>

				<div class="col-lg-12 text-right">
					<?php  echo $pages; ?>
				</div>    			
    		</div>
    		<!-- row -->
    	</form>
    	</div>
    	<div class="col-lg-4">
        

        <?php if(!Uri::has('\/edit\/\d+')){ ?>
    		<div class="divAddnew">
            <form action="" method="post" enctype="multipart/form-data"> 
            <?php echo $alert;?>
	     		<h4>Add new</h4>
	    		<p>
	    			<label><strong>Title</strong></label>
	    			<input type="text" class="form-control" name="send[title]" placeholder="Title" id="txtTitle" />
	    		</p>
                    <p class="pChosen">
                    <div class="row">
                    <div class="col-lg-12">
                    <label><strong>Parent</strong></label>
                    <input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="0" data-method="category" data-key="jsonCategory" placeholder="Type here..." />

                      <div class="listAutoSuggest"><ul></ul></div>  
                      <ul class="ulChosen"></ul>
                    </div>
                    </div>

                    </p>
                <p>
                    <label><strong>Thumbnail</strong></label>
                    <input type="file" class="form-control" name="image" />
                </p>     

	    		<p>
	    			<button type="submit" class="btn btn-primary" name="btnAdd">Add new</button>
	    		</p>   	

                </form>		
    		</div>
            <?php }else{ ?>

    		<div class="divEdit">
            <form action="" method="post" enctype="multipart/form-data"> 
            <?php echo $alert;?>
	     		<h4>Edit</h4>
	    		<p>
	    			<label><strong>Title</strong></label>
	    			<input type="text" class="form-control" name="update[title]" value="<?php if(isset($edit['title']))echo $edit['title'];?>" placeholder="Title" id="txtTitle" />
	    		</p>

                <p class="pChosen">
                        <div class="row">
                        <div class="col-lg-12">
                        <label><strong>Parent</strong></label>
                        <input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="0" data-method="category" data-key="jsonCategory" placeholder="Type here..." />

                          <div class="listAutoSuggest"><ul></ul></div>  
                          <ul class="ulChosen"></ul>
                        </div>
                        </div>

                        </p> 
                <p>
                    <label><strong>Thumbnail</strong></label>
                    <input type="file" class="form-control" name="image" />
                </p>   

                <p>
                    <img src="<?php echo ROOT_URL.$edit['image']?>" class="img-responsive" />
                </p>  

	    		<p>
	    			<button type="submit" class="btn btn-primary" name="btnSave">Save changes</button>
	    		</p>   		
                </form> 	
    		</div>
            <?php } ?>
        
    	</div>
    	
    </div>
  </div>
</div>


  <script type="text/javascript">
            var root_url='<?php echo ROOT_URL;?>';

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
        newLi+='<input type="hidden" name="send[parentid]" class="valueChosen" value="'+theID+'" />';
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