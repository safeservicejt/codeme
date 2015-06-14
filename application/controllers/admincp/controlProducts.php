<?php

class controlProducts
{
	public function index()
	{

        if($match=Uri::match('\/jsonDownload'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Downloads::get(array(
            	'where'=>"where title LIKE '%$keyword%'",
                'orderby'=>'order by title asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="download" data-id="'.$loadData[$i]['downloadid'].'" >'.$loadData[$i]['title'].'</span></li>';
            }

            echo $li;
            die();
        }

        if($match=Uri::match('\/jsonCategory'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Categories::get(array(
            	'where'=>"where title LIKE '%$keyword%'",
                'orderby'=>'order by title asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="category" data-id="'.$loadData[$i]['catid'].'" >'.$loadData[$i]['title'].'</span></li>';
            }

            echo $li;
            die();
        }

        if($match=Uri::match('\/jsonManufacturer'))
        {
            $keyword=String::encode(Request::get('keyword',''));

            $loadData=Manufacturers::get(array(
            	'where'=>"where title LIKE '%$keyword%'",
                'orderby'=>'order by title asc'
                ));

            $total=count($loadData);

            $li='';

            for($i=0;$i<$total;$i++)
            {
                $li.='<li><span data-method="manufacturer" data-id="'.$loadData[$i]['mid'].'" >'.$loadData[$i]['title'].'</span></li>';
            }

            echo $li;
            die();
        }

		$post=array('alert'=>'');

		Model::load('admincp/products');

		if(Uri::has('refreshImages'))
		{
			$prodid=Request::get('send_prodid');

			$result=genProdImages($prodid);

			echo $result;

			die();
		}

		if(Uri::has('removeImage'))
		{
			$prodid=Request::get('send_prodid');

			$image=Request::get('send_image');

			// Database::query("delete from products_images where productNodeid='$prodid' AND image='$image'");

			ProductImages::remove($prodid,"productid='$prodid' AND image='$image'");

			// unlink(ROOT_PATH.$image);

			echo 'OK';

			die();
		}
		if(Uri::has('setSortOrder'))
		{
			$prodid=Request::get('send_prodid');

			$order=Request::get('send_order');

			$image=Request::get('send_image');


			Database::query("update products_images set sort_order='$order' where productid='$prodid' AND image='$image'");

			echo 'OK';

			die();
		}


		if($match=Uri::match('\/products\/(\w+)'))
		{
			if(method_exists("controlProducts", $match[1]))
			{	
				$method=$match[1];

				$this->$method();

				die();
			}
			
		}

		if(Request::has('btnAdd'))
		{
			try {
				
				$post['alert']='<div class="alert alert-success">Add product success</div>';
			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}
		}

		$curPage=0;

		if($match=Uri::match('\/page\/(\d+)'))
		{
			$curPage=$match[1];
		}

		if(Request::has('btnAction'))
		{
			actionProcess();
		}

		if(Request::has('btnSearch'))
		{
			filterProcess();
		}
		else
		{
			$post['pages']=Misc::genPage('admincp/products',$curPage);

			$filterPending='';

			if(Uri::has('\/status\/pending'))
			{
				$filterPending=" AND p.status='0' ";
			}

			$post['theList']=Products::get(array(
				'limitShow'=>20,
				'limitPage'=>$curPage,
				'query'=>"select p.*,c.title as cattitle from products p,categories c where p.catid=c.catid order by p.productid desc",
				'cacheTime'=>15
				));
		}



		System::setTitle('Products list - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('productsList',$post);

		View::make('admincp/footer');

	}

	public function edit()
	{
		if(!$match=Uri::match('\/edit\/(\d+)'))
		{
			Redirect::to(ADMINCP_URL.'products/');
		}


		$postid=$match[1];

		$post=array('alert'=>'');

		if(Request::has('btnSave'))
		{
			try {
				
				updateProcess($postid);

				$post['alert']='<div class="alert alert-success">Save changes success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}

		$loadData=editInfo($postid);

		$post['edit']=$loadData['data'];

		$post['selectImages']=$loadData['images'];

		$post['selectDownloads']=$loadData['downloads'];

		$post['tags']=$loadData['tags'];

		System::setTitle('Edit product - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('productsEdit',$post);

		View::make('admincp/footer');		
	}
	public function addnew()
	{
		$post=array('alert'=>'');

		if(Request::has('btnAdd'))
		{
			try {
				
				insertProcess();

				$post['alert']='<div class="alert alert-success">Add new post success.</div>';

			} catch (Exception $e) {
				$post['alert']='<div class="alert alert-warning">'.$e->getMessage().'</div>';
			}			
		}
		
		System::setTitle('Add new products - '.ADMINCP_TITLE);

		View::make('admincp/head');

		self::makeContents('productsAdd',$post);

		View::make('admincp/footer');		
	}

    public function makeContents($viewPath,$inputData=array())
    {
        View::make('admincp/left');  

        View::make('admincp/'.$viewPath,$inputData);
    }
}

?>