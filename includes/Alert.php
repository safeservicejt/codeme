<?php

class Alert
{
    public function make($alertMessage = '')
    {
        ob_end_clean();
        
        View::make('alert', array('alert' => $alertMessage));

        die();

    }
}


?>