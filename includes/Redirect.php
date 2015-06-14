<?php

class Redirect
{
    public function to($reUrl = '',$code=0)
    {
        $url = $reUrl;
        if (!preg_match('/http/i', $reUrl)) {
            $url = ROOT_URL . $reUrl;
        }

        if((int)$code > 0)
        Response::headerCode($code);

        header("Location: " . $url);

        die();
    }


}


?>