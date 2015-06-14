<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Stats <span class="pull-right">Support email: <strong>safeservicejt@gmail.com</strong></span></h3>
  </div>

  <div class="panel-body">
	<div class="row">
		<div class="col-lg-5">
		<table class="table table-hover">
			<thead>
				<tr>
				<td class="col-lg-5">Total manga:</td>
				<td class="col-lg-5 text-right"><?php echo number_format($totalManga);?></td>
				</tr>
				<tr>
				<td class="col-lg-5">Total chapters:</td>
				<td class="col-lg-5 text-right"><?php echo number_format($totalChapters);?></td>

				</tr>

			</thead>
		</table>
		</div>
		<div class="col-lg-5 col-lg-offset-2">
		<table class="table table-hover pull-right">
			<thead>
				<tr>
				<td class="col-lg-5">Total manga views:</td>
				<td class="col-lg-5 text-right"><?php echo number_format($totalChaptersViews);?></td>

				</tr>
				<tr>
				<td class="col-lg-5">Total chapters views:</td>
				<td class="col-lg-5 text-right"><?php echo number_format($totalMangaViews);?></td>

				</tr>

			</thead>
		</table>
		</div>

	</div>    
    
  </div>
</div>

	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Lastest Manga</h3>
			  </div>

			  <div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<thead>
								<tr>
								<td class="col-lg-8">Title</td>
								<td class="col-lg-4 text-right">Date</td>
								</tr>
							</thead>
							<tbody>
							<?php
							$total=count($lastestManga);

							$li='';

							if(isset($lastestManga[0]['mangaid']))
							for ($i=0; $i < $total; $i++) { 
								$li.='
								<tr>
								<td class="col-lg-8">'.$lastestManga[$i]['title'].'</td>
								<td class="col-lg-4 text-right">'.$lastestManga[$i]['date_added'].'</td>
								</tr>	

								';
							}

							echo $li;
							?>
							
							</tbody>
						</table>
					</div>
				</div>    
			    
			  </div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Lastest Chapters</h3>
			  </div>

			  <div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<thead>
								<tr>
								<td class="col-lg-8">Title</td>
								<td class="col-lg-4 text-right">Date</td>
								</tr>
							</thead>
							<tbody>
							<?php
							$total=count($lastestChapters);

							$li='';

							if(isset($lastestChapters[0]['mangaid']))
							for ($i=0; $i < $total; $i++) { 
								$li.='
								<tr>
								<td class="col-lg-8">'.$lastestChapters[$i]['manga_title'].'</td>
								<td class="col-lg-4 text-right">'.$lastestChapters[$i]['date_added'].'</td>
								</tr>	

								';
							}

							echo $li;
							?>								
							</tbody>
						</table>
					</div>
				</div>    
			    
			  </div>
			</div>
		</div>

	</div>  
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Top Manga Views</h3>
			  </div>

			  <div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<thead>
								<tr>
								<td class="col-lg-9">Title</td>
								<td class="col-lg-3 text-right">Views</td>
								</tr>
							</thead>
							<tbody>
							<?php
							$total=count($viewsManga);

							$li='';

							if(isset($viewsManga[0]['mangaid']))
							for ($i=0; $i < $total; $i++) { 
								$li.='
								<tr>
								<td class="col-lg-9">'.$viewsManga[$i]['title'].'</td>
								<td class="col-lg-3 text-right">'.$viewsManga[$i]['views'].'</td>
								</tr>	

								';
							}

							echo $li;
							?>							
							</tbody>
						</table>
					</div>
				</div>    
			    
			  </div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Top Chapters Views</h3>
			  </div>

			  <div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-hover">
							<thead>
								<tr>
								<td class="col-lg-9">Title</td>
								<td class="col-lg-3 text-right">Views</td>
								</tr>
							</thead>
							<tbody>
							<?php
							$total=count($viewsChapter);

							$li='';

							if(isset($viewsChapter[0]['mangaid']))
							for ($i=0; $i < $total; $i++) { 
								$li.='
								<tr>
								<td class="col-lg-9">'.$viewsChapter[$i]['manga_title'].'</td>
								<td class="col-lg-3 text-right">'.$viewsChapter[$i]['views'].'</td>
								</tr>	

								';
							}

							echo $li;
							?>								
							</tbody>
						</table>
					</div>
				</div>    
			    
			  </div>
			</div>
		</div>

	</div>  
