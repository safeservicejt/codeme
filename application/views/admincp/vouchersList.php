    <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/datepicker/css/datepicker.css">
    <script src="<?php echo ROOT_URL;?>bootstrap/datepicker/js/bootstrap-datepicker.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Voucher list</h3>
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
    							<td class="col-lg-2">Date added</td>
                                <td class="col-lg-7">Code</td>
    							<td class="col-lg-1">Amount</td>
    							<td class="col-lg-1">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['voucherid']))
    						for ($i=0; $i < $total; $i++) { 
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['voucherid'].'" />
	    							</td>
                                    <td class="col-lg-2">'.$theList[$i]['date_added'].'
                                    </td>
                                    <td class="col-lg-7">'.$theList[$i]['code'].'</td>
                                    <td class="col-lg-1">'.$theList[$i]['amount'].'</td>                                    
	    							<td class="col-lg-1 text-right">
	    							<a href="'.ADMINCP_URL.'vouchers/edit/'.$theList[$i]['voucherid'].'" class="btn btn-warning btn-xs">Edit</a>
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
                    <label><strong>Amount:</strong></label>
                    <input type="text" name="send[amount]" class="form-control" placeholder="$0.00" />

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
                    <label><strong>Amount:</strong></label>
                    <input type="text" name="update[amount]" class="form-control" value="<?php echo $edit['amount'];?>" placeholder="$0.00" />
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