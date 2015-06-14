<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">List manga

    <a href="<?php echo THIS_URL?>addnew" class="btn btn-primary btn-xs pull-right" style="color:#ffffff;">Add new</a>
    </h3>
  </div>
  <div class="panel-body">
<div class="row">

		<div class="col-lg-12">
<!-- Form Action -->
		<div class="row">
		<form action="" method="post" enctype="multipart/form-data">
		<div class="col-lg-2">
			<select class="form-control" name="action">		
			<option value="delete">Delete</option>
			<option value="publish">Set as publish</option>
			<option value="unpublish">Set as unpublish</option>   
			<option value="setFeatured">Set as featured</option>   
			<option value="unsetFeatured">unSet featured</option>  
			<option value="completed">Set completed</option>  
			<option value="uncomplete">Set uncomplete</option>  

			</select>

		</div>
		<div class="col-lg-2">
			<button type="submit" class="btn btn-info" name="btnAction">Apply</button>
		</div>
		
		<!-- right -->
		<div class="col-lg-4 pull-right text-right">
		
    <div class="input-group">
      <input type="text" class="form-control" name="txtKeywords" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-primary" name="btnSearch" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
      </span>
    </div><!-- /input-group -->
    
		</div>
		<!-- right -->


		</div>

		<!-- List -->
		<div class="row">
			<div class="col-lg-12">

				<table class="table">
				<thead>
					<tr>
					<td class="col-lg-1"><input type="checkbox" id="selectAll" /></td>
					<td class="col-lg-9">Title</td>
					<td class="col-lg-1">Status</td>
					<td class="col-lg-1"></td>

					</tr>
				</thead>
				<tbody>
				<?php

				$totalRow=count($posts);

				$li='';

				$status='<span class="label label-danger">Pending</span>';

				$views='';

				$date_added='';

				$isFeatured='';

				$isCompleted='';

				if(isset($posts[0]['mangaid']))
				for($i=0;$i<$totalRow;$i++)
				{
					$isFeatured='';

					$status='<span class="label label-danger">Pending</span>';
					
					if((int)$posts[$i]['status']==1)
					{
						$status='<span class="label label-success">Publish</span>';
					}

					$views='<span class="glyphicon glyphicon-eye-open"></span> '.$posts[$i]['views'];

					$date_added='<span class="glyphicon glyphicon-calendar"></span> '.$posts[$i]['date_added'];

					if((int)$posts[$i]['is_featured']==1)
					{
						$isFeatured='<span class="label label-success">Featured</span>';					
					}

					$isCompleted='<span class="label label-primary">Continue..</span>';

					if((int)$posts[$i]['compeleted']==1)
					{
						$isCompleted='<span class="label label-danger">Completed</span>';					
					}

					$li.='

					<tr>
					<td>
					<input type="checkbox" id="cboxID" name="id[]" value="'.$posts[$i]['mangaid'].'" />
					</td>
					<td><a href="'.Manga::url($posts[$i]).'" target="_blank"><strong>'.stripslashes($posts[$i]['title']).'</strong></a>
					<br>
					'.$views.' '.$date_added.' '.$isCompleted.' '.$isFeatured.'
					</td>
					<td>'.$status.'</td>

					<td><a href="'.THIS_URL.'edit/'.$posts[$i]['mangaid'].'" class="btn btn-xs btn-warning">Edit</a></td>

					</tr>
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
		



		</div>		
</form>





	</div>    
    
  </div>
</div>