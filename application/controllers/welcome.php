<?php

class welcome
{
    public function index()
    {
//      Put Cache::enable(); on top of line code on page which you wanna Cached
//        Cache::enable(15);
        //Default expires is 1 mins. You can custom that time.
        // 15 seconds cache of this page will be expired.Now we will test it


        View::make('welcome');
    }


}

?>