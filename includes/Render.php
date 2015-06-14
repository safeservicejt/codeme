<?php

class Render
{
    
	public function rawContent($inputData,$offset=-1,$to=0)
	{
		$replaces=array(
			 '~<script.*?>.*?<\/script>~s'=>'',
			 '~<script>.*?<\/script>~s'=>''
			);
		
		$inputData = preg_replace(array_keys($replaces), array_values($replaces), $inputData);

	 	$inputData=strip_tags($inputData);

	 	$inputData=($offset >= 0)?substr($inputData, 0,strlen($inputData)):$inputData;

	 	return $inputData;
	}

	public function dateFormat($inputDate)
	{
		// $formatStr=GlobalCMS::$setting['default_dateformat'];
		$formatStr=System::getDateFormat();

		// echo $formatStr;die();

		$formatStr=date($formatStr,strtotime($inputDate));

		return $formatStr;
	}

	public function cpanel_menu($zoneName)
	{
       $menu=Plugins::load($zoneName);

       $folderName=Plugins::$renderFolderName;

        $li='';

        if(isset($menu[0]['title']))
        {
            $total=count($menu);
            for ($i=0; $i < $total; $i++) { 
                
                if(!isset($menu[$i]['child']))
                {
                    if(isset($menu[$i]['func']))
                    {
                        $url=isset($menu[$i]['link'])?$menu[$i]['link']:ADMINCP_URL.'plugins/run/'.base64_encode($folderName.':'.$menu[$i]['func']);                     
                    }
                    else
                    {
                        $url=isset($menu[$i]['link'])?$menu[$i]['link']:ADMINCP_URL.'plugins/controller/'.$folderName.'/'.$menu[$i]['controller']; 
                    }


                    $li.='
                    <li>
                        <a href="'.$url.'"><span class="glyphicon glyphicon-list-alt"></span> '.$menu[$i]['title'].'</a>
                    </li>
                    ';
                }
                else
                {
                    $start='<li><a href="javascript:;" data-toggle="collapse" data-target="#'.md5($menu[$i]['title']).'"><span class="glyphicon glyphicon-list-alt"></span> '.$menu[$i]['title'].' <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="'.md5($menu[$i]['title']).'" class="collapse">';

                    $end='</ul></li>';

                    $totalChild=count($menu[$i]['child']);

                    $liChild='';

                    for ($j=0; $j < $totalChild; $j++) { 

                 		

                        if(isset($menu[$i]['child'][$j]['func']))
                        {
                            
                            $url=isset($menu[$i]['child'][$j]['link'])?$menu[$i]['child'][$j]['link']:ADMINCP_URL.'plugins/run/'.base64_encode($folderName.':'.$menu[$i]['child'][$j]['func']);                     
                        }
                        else
                        {
                            $url=isset($menu[$i]['child'][$j]['link'])?$menu[$i]['child'][$j]['link']:ADMINCP_URL.'plugins/controller/'.$folderName.'/'.$menu[$i]['child'][$j]['controller']; 
                        }                        
                   	
                        $liChild.='
                        <li><a href="'.$url.'">'.$menu[$i]['child'][$j]['title'].'</a></li>
                        ';
                    }

                    $li.=$start.$liChild.$end;
                }
            }   
            
           	echo $li;                  
        }


	}

}
?>