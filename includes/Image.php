<?php

class Image
{

    public function upload($keyName='image',$shortPath='uploads/images/')
    {
        $name=$_FILES[$keyName]['name'];

        if(!preg_match('/.*?\.(\w+)/i', $name,$match))
        {
            return false;
        }

        $newName=String::randNumber(10).'.'.$match[1];

        $shortPath.=$newName;

        $fullPath=ROOT_PATH.$shortPath;

        move_uploaded_file($_FILES[$keyName]['tmp_name'], $fullPath);

        return $shortPath;
    }
    public function uploadMultiple($keyName='image',$shortPath='uploads/images/')
    {
        $name=$_FILES[$keyName]['name'][0];

        $resultData=array();

        if(!preg_match('/.*?\.\w+/i', $name))
        {
            return false;
        }

        $total=count($_FILES[$keyName]['name']);

        $tmpShortPath='';

        for($i=0;$i<$total;$i++)
        {
            $tmpShortPath=$shortPath;

            preg_match('/.*?\.(\w+)/i', $_FILES[$keyName]['name'][$i],$matchName);

            $newName=String::randNumber(10).'.'.$matchName[1];

            $tmpShortPath.=$newName;

            $resultData[$i]=$tmpShortPath;

            $fullPath=ROOT_PATH.$tmpShortPath;

            move_uploaded_file($_FILES[$keyName]['tmp_name'][$i], $fullPath);
        }

        return $resultData;
    }

    public function uploadFromUrl($imgUrl,$shortPath='uploads/images/')
    {
        $imgUrl=trim($imgUrl);

        if(!preg_match('/http.*?\.(\w+)/i', $imgUrl,$match))
        {
            return false;
        }

        $newName=String::randNumber(10).'.'.$match[1];

        $shortPath.=$newName;

        $fullPath=ROOT_PATH.$shortPath;

        $imgData=Http::getDataUrl($imgUrl);

        File::create($fullPath,$imgData);

        return $shortPath;
    }

    public function getsize($imagePath)
    {
        list($width, $height) = getimagesize($imagePath);

        $post = array('width' => $width, 'height' => $height);

        return $post;

    }

    public function show($imagePath)
    {
        $imageData = file_get_contents($imagePath);

        $image = imagecreatefromstring($imageData);

        header("Content-type: image/jpg");

        imagejpeg($image);
    }

    public function cropcenter($imagePath, $imageWidth = 100, $imageHeight = 100, $savePath = '')
    {
        $gis = getimagesize($imagePath);
        $type = $gis[2];
        switch ($type) {
            case "1":
                $image = imagecreatefromgif($imagePath);
                break;
            case "2":
                $image = imagecreatefromjpeg($imagePath);
                break;
            case "3":
                $image = imagecreatefrompng($imagePath);
                break;
            default:
                $image = imagecreatefromjpeg($imagePath);
        }
        // $thumb_width = 200;
        // $thumb_height = 150;

        if ($savePath == '') {
            $savePath = $imagePath;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $imageWidth / $imageHeight;

        $new_height = 0;

        $new_width = 0;

        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $imageHeight;
            $new_width = $width / ($height / $imageHeight);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $imageWidth;
            $new_height = $height / ($width / $imageWidth);
        }

        $thumb = imagecreatetruecolor($imageWidth, $imageHeight);

// Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $imageWidth) / 2, // Center the image horizontally
            0 - ($new_height - $imageHeight) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
        imagejpeg($thumb, $savePath, 100);
    }

    public function resize($imagePath, $imageWidth = 100, $imageHeight = 'auto', $savePath = '')
    {
        $imagePath = trim($imagePath);

        $gis = getimagesize($imagePath);
        $type = $gis[2];
        switch ($type) {
            case "1":
                $imorig = imagecreatefromgif($imagePath);
                break;
            case "2":
                $imorig = imagecreatefromjpeg($imagePath);
                break;
            case "3":
                $imorig = imagecreatefrompng($imagePath);
                break;
            default:
                $imorig = imagecreatefromjpeg($imagePath);
        }

        if ($savePath == '') {
            $savePath = $imagePath;
        }
        $x = imagesx($imorig);
        $y = imagesy($imorig);
        if ($imageHeight == 'auto' && is_numeric($imageWidth)) {
            $imageHeight = ($imageWidth / $x * 100) * ($y / 100);
        }
        if ($imageWidth == 'auto' && is_numeric($imageHeight)) {
            $imageWidth = ($imageHeight / $y * 100) * ($x / 100);
        }
        $im = imagecreatetruecolor($imageWidth, $imageHeight);
        if (imagecopyresampled($im, $imorig, 0, 0, 0, 0, $imageWidth, $imageHeight, $x, $y)) {
            imagejpeg($im, $savePath);
        }
    }


}


?>