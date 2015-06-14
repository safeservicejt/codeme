<?php

class Misc
{

	public function genPage($title,$start=0,$max=5,$splitChar='/')
	{
		$endpage=$start+$max;


		$li='';

		$startSplitChar=$splitChar;

		if(!isset($title[0]))
		{
			$startSplitChar='';
		}

		for($i=$start;$i<=$endpage;$i++)
		{
			$li.='<li><a href="'.ROOT_URL.$title.$startSplitChar.'page'.$splitChar.$i.'">'.$i.'</a></li>';
		}

		$prev=$start-1;
		$next=$max+1;


		return '
		<nav>
					<ul class="pagination">
					  <li><a href="'.ROOT_URL.$title.$startSplitChar.'page'.$splitChar.$prev.'">&laquo;</a></li>
					  '.$li.'
					  <li><a href="'.ROOT_URL.$title.$startSplitChar.'page'.$splitChar.$next.'">&raquo;</a></li>
					</ul>
		</nav> 
		';


	}
}


?>