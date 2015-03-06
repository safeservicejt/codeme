<?php

class Compress
{

	public function gzip($inputData,$method='compress',$level=9)
	{
		$resultData='';

		switch ($method) {
			case 'compress':
				$resultData=gzcompress($inputData, $level);
				break;
			case 'uncompress':
				$resultData=gzuncompress($inputData);
				break;
			
		}

		return $resultData;
	}
}
?>