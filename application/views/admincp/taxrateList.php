  <link rel="stylesheet" href="<?php echo ROOT_URL;?>bootstrap/chosen/css/chosen.min.css">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Taxrate list</h3>
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
    							<td class="col-lg-10">Title</td>
    							<td class="col-lg-1">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['taxid']))
    						for ($i=0; $i < $total; $i++) { 
    							$li.='
	    						<!-- tr -->
	    						<tr>
	    							<td class="col-lg-1">
	    								<input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['taxid'].'" />
	    							</td>
	    							<td class="col-lg-10">'.$theList[$i]['title'].'</td>
	    							<td class="col-lg-2 text-right">
	    							<a href="'.ADMINCP_URL.'taxrate/edit/'.$theList[$i]['taxid'].'" class="btn btn-warning btn-xs">Edit</a>
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
                    <label><strong>Type:</strong></label>
                    <select class="form-control" name="send[type]">
                    <option value="percent">Percent</option>
                    <option value="fixedamount">Fixed amount</option>
                    </select>
                    </p>
                    <p>
                    <label><strong>Rate: (default currency is dollars)</strong></label>
                    <input type="text" name="send[rate]" class="form-control" value="0.00" placeholder="0.00" />
                    </p>
                    <p>
                    <label><strong>Apply to countries:</strong></label>
                    <select multiple class="form-control" name="countries[]" id="jsCountries" data-placeholder="Choose countries...">
                    <option value="worldwide" selected>Worldwide</option>

                    <?php
                        $total=count($listCountries);

                        $li='';
                        for($i=0;$i<$total;$i++)
                        {
                            $li.='<option value="'.$listCountries[$i]['iso_code_2'].'">'.$listCountries[$i]['name'].'</option>';
                        }

                        echo $li;
                    ?>
                    </select>
                    </p>   

	    		<p>
	    			<button type="submit" class="btn btn-primary" name="btnAdd">Add new</button>
	    		</p>   	

                </form>		
    		</div>
            <?php }else{ ?>

    		<div class="divEdit">
            <form action="" method="post" enctype="multipart/form-data"> 
   
                    <p>
                    <h4>Edit</h4>
                    </p>
                    <?php echo $alert;?>
                    <p>
                    <label><strong>Title:</strong></label>
                    <input type="text" name="update[title]" class="form-control" value="<?php if(isset($edit['title']))echo $edit['title'];?>" placeholder="Title..." />
                    </p>

                    <p>
                    <label><strong>Type:</strong></label>
                    <select class="form-control" name="update[type]">
                    <option value="percent" <?php if(isset($edit['type']) && $edit['type']=='percent')echo 'selected';?>>Percent</option>
                    <option value="fixedamount" <?php if(isset($edit['type']) && $edit['type']=='fixedamount')echo 'selected';?>>Fixed amount</option>
                    </select>
                    </p>
                    <p>
                    <label><strong>Rate: (default currency is dollars)</strong></label>
                    <input type="text" name="update[rate]" class="form-control" value="<?php if(isset($edit['rate']))echo $edit['rate'];?>" placeholder="0.00" />
                    </p>
                    <p>
                    <label><strong>Apply to countries:</strong></label>
                    <select multiple class="form-control" name="countries[]" id="jsCountries" data-placeholder="Choose countries...">


                    <?php
                        $total=count($listCountries);

                        $li='';
                        for($i=0;$i<$total;$i++)
                        {
                            if(in_array($listCountries[$i]['iso_code_2'], $edit['countries']))
                            {
                                $li.='<option value="'.$listCountries[$i]['iso_code_2'].'" selected>'.$listCountries[$i]['name'].'</option>';   
                            }
                            else
                            {
                                $li.='<option value="'.$listCountries[$i]['iso_code_2'].'">'.$listCountries[$i]['name'].'</option>';                            
                            }

                        }
                        
                        echo $li;
                    ?>
                    </select>
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
<script src="<?php echo ROOT_URL;?>bootstrap/chosen/js/chosen.jquery.min.js"></script>
  <script type="text/javascript">
      $("#jsCountries").chosen();
  </script>