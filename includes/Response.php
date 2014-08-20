<?php



class Response
{

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

            $download_rate = 150.5;

            if (is_null($fileName)) $fileName = basename($filePath);
            // send headers
            header('Cache-control: private');
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . filesize($filePath));
            header('Content-Disposition: filename=' . $filePath);

            // flush content
            flush();

            // open file stream
            $file = fopen($filePath, "r");

            while (!feof($file)) {

                // send the current file part to the browser
                print fread($file, round($download_rate * 1024));

                // flush the content to the browser
                flush();

                // sleep one second
                sleep(1);
            }

            // close file stream
            fclose($file);


            return true;

        }

        return false;

    }

}

?>