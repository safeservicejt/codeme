    <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/datepicker/css/datepicker.css">
    <script src="<?php echo ROOT_URL;?>bootstrap/datepicker/js/bootstrap-datepicker.js"></script>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Coupons list</h3>
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
    							<td class="col-lg-5">Title</td>
                                <td class="col-lg-4">Code</td>
    							<td class="col-lg-1">Amount</td>
    							<td class="col-lg-1">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['couponid']))
    						for ($i=0; $i < $total; $i++) { 
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['couponid'].'" />
	    							</td>
                                    <td class="col-lg-5">'.$theList[$i]['title'].'
                                    <br>
                                    '.$theList[$i]['date_added'].'
                                    </td>
                                    <td class="col-lg-4">'.$theList[$i]['code'].'</td>
                                    <td class="col-lg-1">'.$theList[$i]['amount'].'</td>                                    
	    							<td class="col-lg-1 text-right">
	    							<a href="'.ADMINCP_URL.'coupons/edit/'.$theList[$i]['couponid'].'" class="btn btn-warning btn-xs">Edit</a>
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
                    <label><strong>Coupon type:</strong></label>
                    <select class="form-control" name="send[type]">
                    <option value="percent">Percent</option>
                    <option value="money">Money</option>
                    </select>
                    </p>

                    <p>
                    <label><strong>Is free shipping ?</strong></label>
                    <select class="form-control" name="send[freeshipping]">
                    <option value="1">Yes, Free shipping</option>
                    <option value="0">No</option>
                    </select>
                    </p>

                    <p>
                    <label><strong>Amount:</strong></label>
                    <input type="text" name="send[amount]" class="form-control" placeholder="Amount..." />

                    </p>
                    <p>
                    <label><strong>Date start:</strong></label>
                    <input type="text" name="send[date_start]" data-provide="datepicker" class="datepicker form-control " value="<?php echo date('Y-m-d');?>" placeholder="Date start..." />
                    </p>
                    <p>
                    <label><strong>Date end:</strong></label>
                    <input type="text" name="send[date_end]" data-provide="datepicker" class="datepicker form-control " value="<?php echo date('Y-m-d');?>" placeholder="Date end..." />
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
                    <input type="text" name="update[title]" class="form-control" value="<?php echo $edit['title'];?>" placeholder="Title..." />

                    </p>
                        <p>
                    <label><strong>Coupon type:</strong></label>
                    <select class="form-control" name="update[type]">
                    <option value="percent" <?php if($edit['type']=='percent')echo 'selected';?>>Percent</option>
                    <option value="money" <?php if($edit['type']=='money')echo 'selected';?>>Money</option>
                    </select>
                    </p>

                    <p>
                    <label><strong>Is free shipping ?</strong></label>
                    <select class="form-control" name="update[freeshipping]">
                    <option value="1" <?php if((int)$edit['freeshipping']==1)echo 'selected';?>>Yes, Free shipping</option>
                    <option value="0" <?php if((int)$edit['freeshipping']==0)echo 'selected';?>>No</option>
                    </select>
                    </p>

                    <p>
                    <label><strong>Amount:</strong></label>
                    <input type="text" name="update[amount]" class="form-control" value="<?php echo $edit['amount'];?>" placeholder="Amount..." />

                    </p>
                    <p>
                    <label><strong>Date start:</strong></label>
                    <input type="text" name="update[date_start]" data-provide="datepicker" value="<?php echo $edit['date_start'];?>" class="datepicker form-control " placeholder="Date start..." />
                    </p>
                    <p>
                    <label><strong>Date end:</strong></label>
                    <input type="text" name="update[date_end]" data-provide="datepicker" value="<?php echo $edit['date_end'];?>" class="datepicker form-control " placeholder="Date end..." />
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
            <script>
            $(document).ready(function(){
                $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd'
                    })
            });
            </script>
