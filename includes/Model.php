<?php

class Model
{

    public function load($modelName = '')
    {
        $path = MODELS_PATH . $modelName . '.php';

        if (!file_exists($path)) Alert::make('Model <b>' . $modelName . '</b> not exists.');

        include($path);
    }


}

?>