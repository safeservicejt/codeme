<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List payment methods

    <a href="<?php echo ADMINCP_URL;?>paymentmethods/import" class="btn btn-primary btn-xs pull-right" style="color:#ffffff;">Import</a>
    </h3>
  </div>
  <div class="panel-body">
<div class="row">

		<div class="col-lg-12">
<!-- Form Action -->
		<form action="" method="post" enctype="multipart/form-data">




		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table">
				<thead>
					<tr>
					<td class="col-lg-1">#</td>
					<td class="col-lg-3">Title</td>
					<td class="col-lg-8">Descriptions</td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($theList);

				$li='';

				$status='';

				$activate='';

				$control='';

				$pluginSetting='';


				for($i=0;$i<$totalRow;$i++)
				{
					$status='<a href="'.ROOT_URL.'admincp/paymentmethods/uninstall/'.$theList[$i]['foldername'].'">Uninstall</a>';		

					$activate='<a href="'.ROOT_URL.'admincp/paymentmethods/deactivate/'.$theList[$i]['foldername'].'">Deactivate</a>&nbsp;&nbsp;&nbsp;';	

					$control='';	

					$pluginSetting='';	

					if((int)$theList[$i]['install'] == 0)
					{
			
						$status='<a href="'.ROOT_URL.'admincp/paymentmethods/install/'.$theList[$i]['foldername'].'">Install</a>';						
					}
					if((int)$theList[$i]['setting'] == 1 && (int)$theList[$i]['install']==1)
					{
			
						$pluginSetting='<a href="'.ROOT_URL.'admincp/paymentmethods/setting/'.$theList[$i]['foldername'].'">Setting</a>&nbsp;&nbsp;&nbsp;';						
					}

					if((int)$theList[$i]['status'] == 0 && (int)$theList[$i]['install']==1)
					{
			
						$activate='<a href="'.ROOT_URL.'admincp/paymentmethods/activate/'.$theList[$i]['foldername'].'">Activate</a>&nbsp;&nbsp;&nbsp;';		
											
					}elseif((int)$theList[$i]['status'] == 0 && (int)$theList[$i]['install']==0)
					{
			
						$activate='';		
											
					}

					$li.='

					<tr>
					<td>
					<input type="checkbox" name="id[]" value="'.$theList[$i]['foldername'].'" />
					</td>
					<td>'.stripslashes($theList[$i]['title']).'
					<p style="margin-top:10px;">
					'.$pluginSetting.$activate.$status.'
					</p>
					</td>
					<td>'.stripslashes($theList[$i]['summary']).'

					<p style="margin-top:10px;">
					<span>Version '.$theList[$i]['version'].'</span> | By <a href="'.$theList[$i]['url'].'">'.$theList[$i]['author'].'</a> &nbsp;| 
					</p>

					</td>

					</tr>
					';

				}

				echo $li;

				?>


				</tbody>
				</table>
			</div>
		</div>
		</form>



		</div>		






	</div>    
    
  </div>
</div>