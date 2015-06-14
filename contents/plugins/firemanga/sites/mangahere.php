<?php

class MangaAutoLeech
{
	public function index($method='manga',$url='')
	{

		if(!isset($url[4]))
		{
			throw new Exception("Error. Url not valid");			
		}


		switch ($method) {
			case 'manga':
						try {
							$this->fetchManga($url);
							
						} catch (Exception $e) {

							throw new Exception($e->getMessage());
						}
				break;
			case 'chapter':
						try {
							$this->fetchChapter($url);
							
						} catch (Exception $e) {

							throw new Exception($e->getMessage());
						}
				break;

		}

	}

	public function fetchManga($url)
	{

		if(!preg_match('/\/manga\//i', $url))
		{
			throw new Exception("Url not valid.");
		}

		$getData=Http::getDataUrl($url,'no');

		$insertData=array();

		if(!preg_match('/<h1 class="title"><span class="title_icon"><\/span>(.*?)<\/h1>/i', $getData,$match))
		{
			throw new Exception("Can not parse data.");
		}

		$insertData['title']=ucwords(strtolower($match[1]));

		preg_match('/<span id="current_rating" class="scores">(\d+)<em>/i', $getData,$match);

		$insertData['rating']=$match[1];

		preg_match('/<li><label>Genre\(s\):<\/label>(.*?)<\/li>
/i', $getData,$match);

		$listCat=$match[1];

		$listCat=explode(",", $listCat);

		preg_match('/<li><label>Author\(s\):<\/label><a .*? href=".*?">(.*?)<\/a><\/li>
/i', $getData,$match);

		$authorName=$match[1];

		$insertData['compeleted']=1;

		if(preg_match('/<li><label>Status:<\/label>Ongoing/i', $getData))
		{
			$insertData['compeleted']=0;
		}

		$insertData['summary']='';

		if(preg_match('/<li><label><h2>.*? Manga<\/h2> Summary:<\/label>(.*?)<\/ul>/is', $getData,$match))
		{
			$insertData['summary']=strip_tags($match[1],'<p>');

			$replace=array(
				'display:none;'=>'',
				'Show less'=>''
				);

			$insertData['summary']=str_replace(array_keys($replace), array_values($replace), $insertData['summary']);

		}

		$imgUrl='';

		if(preg_match('/<img src="(http.*?\/manga\/13739\/cover.jpg)\?v=\d+"/i', $getData,$match))
		{
			$imgUrl=$match[1];
		}
		elseif(preg_match('/<img src="(http.*?\/manga\/13739\/cover.jpg)"/i', $getData,$match))
		{
			$imgUrl=$match[1];
		}

		if(isset($imgUrl[5]))
		{
			$imgUrl=File::uploadFromUrl($imgUrl,'uploads/images/');

			$insertData['image']=$imgUrl;
		}

		$loadData=Manga::get(array(
			'where'=>"where title='".$insertData['title']."'"
			));

		if(isset($loadData[0]['title']))
		{
			$this->removeImage($insertData['image']);

			throw new Exception("This manga have been exists.");
		}

		if(!$id=Manga::insert($insertData))
		{
			$this->removeImage($insertData['image']);

			throw new Exception("Error. ".Database::$error);
		}

		$totalCat=count($listCat);

		for ($i=0; $i < $totalCat; $i++) { 

			$catName=trim($listCat);

			$loadData=Categories::get(array(
				'where'=>"where cattitle LIKE '%$catName%'"
				));

			if(isset($loadData[0]['catid']))
			{
				MangaCategories::insert(array(
					'catid'=>$loadData[0]['catid'],
					'mangaid'=>$id
					));
			}
			else
			{
				$catid=Categories::insert(array(
					'cattitle'=>$catName
					));

				MangaCategories::insert(array(
					'catid'=>$loadData[0]['catid'],
					'mangaid'=>$id
					));
			}
		}
		
	}

	public function fetchChapter($url)
	{
		if(!preg_match('/\/manga\/.*?\/c(\d+)/i',$url,$match))
		{
			throw new Exception("Url not valid.");
		}


		$insertData=array();

		$insertData['number']=$match[1];

		$getData=Http::getDataUrl($url,'no');

		$insertData=array();

		if(!preg_match_all('/(http.*?\/manga\/.*?\/c\d+\/)\d+\.html/i', $getData, $matches))
		{
			$listUrls=$matches[1];

			$total=count($listUrls);

			$total++;

			$listIMG=array();

			for ($i=0; $i < $total; $i++) { 

				$theUrl=$matches[1][0].$i.'.html';

				$imgData=Http::getDataUrl($theUrl,'no');

				if(preg_match('/<img src="(http:\/\/a\.mhcdn\.net.*?\.\w+)\?v=/i', $imgData,$match))
				{
					$listIMG[]=$match[1];
				}
				elseif(preg_match('/<img src="(http:\/\/a\.mhcdn\.net.*?\.\w+)"/i', $imgData,$match))
				{
					$listIMG[]=$match[1];
				}
			}

			$listShortPath=array();

			$isUpload=Request::get('isUpload','url');

			$insertData['content_type']=$isUpload;

			$insertData['mangaid']=Request::get('mangaid');

			if($isUpload=='host')
			{
				$total=count($listIMG);

				for ($i=0; $i < $total; $i++) { 
					
					if(isset($listIMG[$i][5]))
					{
						$listShortPath[]=Http::getDataUrl($listIMG[$i],'no');
					}
					
				}

			}
			else
			{
				$listShortPath=$listIMG;
			}

			$insertData['content']=implode("\r\n", $listShortPath);

			if(!$id=MangaChapters::insert($insertData))
			{
				if($isUpload=='host')
				{
					$total=count($listShortPath);

					for ($i=0; $i < $total; $i++) { 
						$this->removeImage($listShortPath[$i]);
					}
				}
				
				throw new Exception("Error. ".Database::$error);
			}

		}
	}

	public function removeImage($image)
	{
		$image=ROOT_PATH.$image;

		if(file_exists($image))
		{
			unlink($image);

			$image=dirname($image);

			rmdir($image);
		}
	}

}

// $run=new MangaAutoLeech();
// $run->index();

?>