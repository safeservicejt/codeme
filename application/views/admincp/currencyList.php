    <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/datepicker/css/datepicker.css">
    <script src="<?php echo ROOT_URL;?>bootstrap/datepicker/js/bootstrap-datepicker.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Currency list</h3>
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
    							<td class="col-lg-6">Title</td>
                                <td class="col-lg-2">Code</td>
    							<td class="col-lg-2">Value</td>
    							<td class="col-lg-1">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['currencyid']))
    						for ($i=0; $i < $total; $i++) { 
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['currencyid'].'" />
	    							</td>
                                    <td class="col-lg-6">'.$theList[$i]['title'].'</td>
                                    <td class="col-lg-2">'.$theList[$i]['code'].'</td>
                                    <td class="col-lg-2">'.$theList[$i]['dataValue'].'</td>                                  
	    							<td class="col-lg-1 text-right">
	    							<a href="'.ADMINCP_URL.'currency/edit/'.$theList[$i]['currencyid'].'" class="btn btn-warning btn-xs">Edit</a>
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
                    <input type="text" name="send[title]" class="form-control" placeholder="Currency title..." />
                    </p>
                    <p>
                    <label><strong>Code:</strong></label>
                    <input type="text" name="send[code]" class="form-control" placeholder="Code..." />
                    </p>
                    <p>
                    <label><strong>Symbol left:</strong></label>
                    <input type="text" name="send[symbolLeft]" class="form-control" placeholder="Symbol left..." />
                    </p>
                    <p>
                    <label><strong>Symbol right:</strong></label>
                    <input type="text" name="send[symbolRight]" class="form-control" placeholder="Symbol right.." />
                    </p>
                    <p>
                    <label><strong>Value:</strong></label>
                    <input type="text" name="send[dataValue]" class="form-control" placeholder="Value..." value="1.0000" />
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
                    <input type="text" name="update[title]" class="form-control" placeholder="Currency title..." value="<?php echo $edit['title'];?>" />
                    </p>
                    <p>
                    <label><strong>Code:</strong></label>
                    <input type="text" name="update[code]" class="form-control" placeholder="Code..." value="<?php echo $edit['code'];?>" />
                    </p>
                    <p>
                    <label><strong>Symbol left:</strong></label>
                    <input type="text" name="update[symbolLeft]" class="form-control" placeholder="Symbol left..." value="<?php echo $edit['symbolLeft'];?>" />
                    </p>
                    <p>
                    <label><strong>Symbol right:</strong></label>
                    <input type="text" name="update[symbolRight]" class="form-control" placeholder="Symbol right.." value="<?php echo $edit['symbolRight'];?>" />
                    </p>
                    <p>
                    <label><strong>Value:</strong></label>
                    <input type="text" name="update[dataValue]" class="form-control" placeholder="Value..." value="<?php echo $edit['dataValue'];?>" />
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