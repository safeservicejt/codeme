<?php

class Alert
{
    public function make($alertMessage = '')
    {

        View::make('alert', array('alert' => $alertMessage));

        die();

    }
}


?>