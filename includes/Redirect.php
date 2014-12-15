<?php

class Redirect
{
    public function to($reUrl = '')
    {
        $url = $reUrl;
        if (!preg_match('/http/i', $reUrl)) {
            $url = ROOT_URL . $reUrl;
        }

        header("Location: " . $url);

        die();
    }


}


?>