<?php

class welcome
{

    public function index()
    {
        echo 'Welcome';
    }
    public function ac()
    {

        echo 'acacacac';
    }

    public function ab()
    {
        echo 'ab';

    }
    public function getThongTin()
    {
        Cache::enable(15);

        echo 'Thog tin';
    }
    public function getTimKiem()
    {
//        Cache::enable();

        echo 'Tim kiem';
    }

}

?>