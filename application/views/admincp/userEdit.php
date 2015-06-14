<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit user</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
        <?php echo $alert;?>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- row -->
            <div class="row">
                <div class="col-lg-6">
                      <p>
                            <strong>Group:</strong>
                          <select class="form-control" name="send[groupid]">

                              <?php 
                              $total=count($listGroups);

                              $li='';


                                $li.='<option value="'.$edit['groupid'].'" selected>'.$edit['group_title'].'</option>';


                              if(isset($listGroups[0]['groupid']))
                                for ($i=0; $i < $total; $i++) { 
                                    
                                    $li.='<option value="'.$listGroups[$i]['groupid'].'">'.$listGroups[$i]['group_title'].'</option>';
                                }

                                echo $li;
                              ?>
                          </select>
                      </p>  

                      <p>
                            <strong>First name:</strong>
                          <input type="text" class="form-control" placeholder="First name" name="send[firstname]" value="<?php echo $edit['firstname'];?>" />
                      </p>

                      <p>
                            <strong>Last name:</strong>
                          <input type="text" class="form-control" placeholder="Last name" name="send[lastname]"  value="<?php echo $edit['lastname'];?>" />
                      </p>

                      <p>
                            <strong>Username:</strong>
                          <input type="text" class="form-control" placeholder="Username" name="send[username]"  value="<?php echo $edit['username'];?>" />
                      </p>

                      <p>
                            <strong>Email:</strong>
                          <input type="email" class="form-control" placeholder="Email" name="send[email]"  value="<?php echo $edit['email'];?>" />
                      </p>

                </div>
                <div class="col-lg-6">
                      <p>
                            <strong>Address 1:</strong>
                          <input type="text" class="form-control" placeholder="Address 1" name="address[address_1]"  value="<?php echo $edit['address_1'];?>" />
                      </p>
                      <p>
                            <strong>Address 2:</strong>
                          <input type="text" class="form-control" placeholder="Address 2" name="address[address_2]"  value="<?php echo $edit['address_2'];?>" />
                      </p>
                      <p>
                            <strong>City:</strong>
                          <input type="text" class="form-control" placeholder="City" name="address[city]"  value="<?php echo $edit['city'];?>" />
                      </p>
                      <p>
                            <strong>State:</strong>
                          <input type="text" class="form-control" placeholder="State" name="address[state]"  value="<?php echo $edit['state'];?>" />
                      </p>
                      <p>
                            <strong>Post code:</strong>
                          <input type="text" class="form-control" placeholder="Post code" name="address[postcode]"  value="<?php echo $edit['postcode'];?>" />
                      </p>
                      <p>
                            <strong>Country:</strong>
                          <input type="text" class="form-control" placeholder="Country" name="address[country]"  value="<?php echo $edit['country'];?>" />
                      </p>

                </div>

            </div>
            <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="btnSave" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
        </div>
        
    </div>
  </div>
</div>
<div class="panel panel-warning">
  <div class="panel-heading">
    <h3 class="panel-title">Change password</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-lg-12">
    	<form action="" method="post" enctype="multipart/form-data">
    		<!-- row -->
    		<div class="row">
                <div class="col-lg-12">
                      <p>
                            <strong>New password:</strong>
                          <input type="text" class="form-control" name="password" placeholder="New password" />
                      </p>

                </div>

    		</div>
    		<!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="btnChangePassword" class="btn btn-primary">Change</button>
                </div>
            </div>
    	</form>
    	</div>
    	
    </div>
  </div>
</div>

<script>

$(document).ready(function(){


});
</script>