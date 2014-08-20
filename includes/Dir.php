<?php

class Dir
{
    public function create($dirPath = '')
    {
        mkdir($dirPath);
    }

    public function listFiles($dirPath = '')
    {
        if (is_dir($dirPath)) {
            return scandir($dirPath);
        }

        return false;
    }
}

?>