<?php

class SelfApi
{
	public function route()
	{
		$listRoute=array(
            'get_list_category'=>'listCategory',
            'get_list_author'=>'listAuthor',
 			'get_list_manga'=>'listManga'

			);

		return $listRoute;
	}

    public function listManga()
    {

        $keyword=String::encode(Request::get('keyword',''));

        $loadData=Manga::get(array(
            'where'=>"where title LIKE '%$keyword%'",
            'orderby'=>'order by title asc'
            ));

        $total=count($loadData);

        $li='';

        for($i=0;$i<$total;$i++)
        {
            $li.='<li><span data-method="manga" data-id="'.$loadData[$i]['mangaid'].'" >'.$loadData[$i]['title'].'</span></li>';
        }


        return $li;
    }

    public function listCategory()
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


        return $li;
    }

	public function listAuthor()
	{

        $keyword=String::encode(Request::get('keyword',''));

        $loadData=MangaAuthors::get(array(
            'where'=>"where title LIKE '%$keyword%'",
            'orderby'=>'order by title asc'
            ));

        $total=count($loadData);

        $li='';

        for($i=0;$i<$total;$i++)
        {
            $li.='<li><span data-method="author" data-id="'.$loadData[$i]['authorid'].'" >'.$loadData[$i]['title'].'</span></li>';
        }


        return $li;
	}
	
}


?>