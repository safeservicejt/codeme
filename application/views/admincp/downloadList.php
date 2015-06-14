    <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/datepicker/css/datepicker.css">
    <script src="<?php echo ROOT_URL;?>bootstrap/datepicker/js/bootstrap-datepicker.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">File list</h3>
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
    							<td class="col-lg-6">File Title</td>
                                <td class="col-lg-4">File Name</td>
    							<td class="col-lg-1">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['downloadid']))
    						for ($i=0; $i < $total; $i++) { 
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['downloadid'].'" />
	    							</td>
                                    <td class="col-lg-6">'.$theList[$i]['title'].'
                                    <br>
                                    <small>Date: '.$theList[$i]['date_added'].'</small>
                                    </td>
                                    <td class="col-lg-4">'.basename($theList[$i]['filename']).'</td>
                                    <td class="col-lg-1">
	    							<a href="'.ADMINCP_URL.'downloads/edit/'.$theList[$i]['downloadid'].'" class="btn btn-warning btn-xs">Edit</a>
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
                    <label><strong>Title:</strong></label>
                    <input type="text" name="send[title]" class="form-control" placeholder="Title..." />
                    </p>
                    <p>
                    <label><strong>Remaining:</strong></label>
                    <input type="text" name="send[remaining]" class="form-control" placeholder="Remaining..." value="1" />
                    </p>
            
                    <p>
                    <label><strong>File:</strong></label>
                    <input type="file" name="theFile" class="form-control" />

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
                    <label><strong>Title:</strong></label>
                    <input type="text" name="update[title]" class="form-control" placeholder="Title..." value="<?php echo $edit['title'] ?>" />
                    </p>
                    <p>
                    <label><strong>Remaining:</strong></label>
                    <input type="text" name="update[remaining]" class="form-control" placeholder="Remaining..."  value="<?php echo $edit['remaining'] ?>" />
                    </p>
                    <p>
                    <button type="submit" class="btn btn-primary" name="btnSave">Save Changes</button>
                    </p> 		
                </form> 	
    		</div>
            <?php } ?>
        
    	</div>
    	
    </div>
  </div>
</div>