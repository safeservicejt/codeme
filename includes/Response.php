<?php


class Response
{

    public function rss()
    {
        header("Content-Type: application/xml; charset=UTF-8");
    }

    public function json($jsonData = '')
    {
        if (is_array($jsonData)) {
            return json_encode($jsonData);
        }

        return json_decode($jsonData, true);
    }

    public function download($filePath = '', $fileName = null)
    {
        if (file_exists($filePath)) {

            $fileName = is_null($fileName) ? basename($fileName) : $fileName;

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $fileName);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            ob_clean();
            flush();
            readfile($file);

        }

        return false;

    }

}

?>