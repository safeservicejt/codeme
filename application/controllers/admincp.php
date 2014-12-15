<?php

class admincp
{

    //Default func will be load when call to this controller
    public function index()
    {
        echo 'ok';
    }

    public function getHello()
    {
        Route::get('halo','admincp@halo');
        // Alert::make('hello');
    }
     public function getHalo()
    {
        Alert::make('halo');
    }

}

?>