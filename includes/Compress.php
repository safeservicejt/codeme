<?php

class Compress
{

	public function gzip($inputData,$method='compress')
	{
		$resultData='';

		switch ($method) {
			case 'compress':
				$resultData=gzcompress($inputData, 9);
				break;
			case 'uncompress':
				$resultData=gzuncompress($inputData);
				break;
			
		}

		return $resultData;
	}
}
?>