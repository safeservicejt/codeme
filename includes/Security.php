<?php

class Security
{
    public function ipAllow($ipStr = '')
    {
        $ipSource = $_SERVER['REMOTE_ADDR'];

        if ($ipSource != $ipStr) load_page_not_found();
    }



}

?>