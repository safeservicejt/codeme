<?php


function importProcess()
{

	$resultData=File::uploadMultiple('theFile','uploads/tmp/');

	$total=count($resultData);

	for($i=0;$i<$total;$i++)
	{
		$targetPath='';

		$theFile=$resultData[$i];

		$sourcePath=ROOT_PATH.$theFile;

		$shortPath='contents/plugins/'.basename($theFile);

		$targetPath.=$shortPath;

		File::move($sourcePath,$targetPath);

		$sourcePath=dirname($sourcePath);

		rmdir($sourcePath);

		File::unzipModule($targetPath,'yes');
	}
}

?>