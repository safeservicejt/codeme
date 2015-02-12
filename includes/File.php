<?php


class File
{
    public function exists($filePath = '')
    {
        if (isset($filePath[1]) && file_exists($filePath)) {
            return true;
        }

        return false;
    }

    public function create($filePath = '', $fileData = '', $writeMode = 'w')
    {
        $fp = fopen($filePath, $writeMode);
        fwrite($fp, $fileData);
        fclose($fp);
    }

    public function writeoverride($filePath = '', $fileData = '')
    {
        self::create($filePath, $fileData);
    }

    public function write($filePath = '', $fileData = '')
    {
        self::create($filePath, $fileData, 'a');
    }

    public function remove($filePath = '')
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function read($filePath = '')
    {

        if (file_exists($filePath)) {
            $data = file_get_contents($filePath);

            return $data;
        }

        return false;
    }

    public function readallline($filePath = '')
    {
        if (file_exists($filePath)) {
            $data = file($filePath);

            return $data;
        }

        return false;
    }

    public function getcontenttype($filePath = '')
    {
        if (file_exists($filePath)) {
            return mime_content_type($filePath);
        }

        return false;
    }

    public function getmodifytime($filePath = '')
    {
        if (file_exists($filePath)) {
            return filemtime($filePath);
        }

        return false;
    }

    public function getcreatetime($filePath = '')
    {
        if (file_exists($filePath)) {
            return fileatime($filePath);
        }

        return false;
    }

    public function getextension($fileName = '')
    {
        if (preg_match('/\.(\w+)$/i', $fileName, $matches)) {
            return $matches[1];
        }

        return false;
    }

    public function getsize($filePath = '')
    {
        if (file_exists($filePath)) {
            return filesize($filePath);
        }

        return false;

    }

    public function download($filePath)
    {
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($fileName));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        ob_clean();
        flush();
        readfile($filePath);
        exit;
    }

    public function move($fileSource = '', $fileDesc = '')
    {
        if (file_exists($fileSource)) {
            if (file_exists($fileDesc)) {
                unlink($fileDesc);
            }

            copy($fileSource, $fileDesc);

            unlink($fileSource);

            return true;
        }

        return false;

    }

    public function copy($fileSource = '', $fileDesc = '')
    {
        if (file_exists($fileSource)) {
            if (file_exists($fileDesc)) {
                unlink($fileDesc);
            }

            copy($fileSource, $fileDesc);

            return true;
        }

        return false;

    }

    public function rename($oldName = '', $newName = '')
    {
        if (file_exists($oldName)) {
            $dir = dirname($oldName);

            rename($oldName, $dir . '/' . $newName);

            return true;
        }

        return false;

    }

    public function name($Url = '')
    {
        return basename($Url);
    }


}


?>