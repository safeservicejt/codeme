<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Reviews list</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<form action="" method="post" enctype="multipart/form-data">
    		<!-- row -->
    		<div class="row">
    			<div class="col-lg-4">
                    <div class="input-group input-group-sm">
                        <select class="form-control" name="action">
                            <option value="delete">Delete</option>
                            <option value="publish">Publish</option>
                            <option value="unpublish">unPublish</option>

                        </select>
                       <span class="input-group-btn">
                        <button class="btn btn-primary" name="btnAction" type="submit">Apply</button>
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
                                <td class="col-lg-9">Product title</td>

                                <td class="col-lg-1 text-right">Status</td>
    							<td class="col-lg-1 text-right">#</td>
    						</tr>
    					</thead>

    					<tbody>
    					<?php
    						$total=count($theList);

    						$li='';

    						if(isset($theList[0]['reviewid']))
    						for ($i=0; $i < $total; $i++) { 

                                $status='<span class="label label-success">Publish</span>';

                                if((int)$theList[$i]['status']==0)
                                {
                                    $status='<span class="label label-danger">unPublish</span>';
                                }

    							$li.='
	    						<!-- tr -->
	    						<tr>
                                    <td class="col-lg-1">
                                        <input type="checkbox" id="cboxID" name="id[]" value="'.$theList[$i]['reviewid'].'" />
                                    </td>
 	    							<td class="col-lg-2">
	    								<span>'.$theList[$i]['date_addedFormat'].'</span>
	    							</td>

                                    <td class="col-lg-9">'.$theList[$i]['title'].'
                                    <br>
                                    <span>Username: '.$theList[$i]['username'].'</span> <span>Email: '.$theList[$i]['email'].'</span>
                                    </td>
                                 
                                    <td class="col-lg-1 text-right">'.$status.'</td>
                                    <td class="col-lg-1 text-right">
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
    	
    </div>
  </div>
</div>

