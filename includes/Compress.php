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

	public function gzdecode($data){
	  $g=tempnam('/tmp','ff');
	  @file_put_contents($g,$data);
	  ob_start();
	  readgzfile($g);
	  $d=ob_get_clean();
	  return $d;
	}
	
}
?>