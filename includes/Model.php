<?php

class Model
{

    public function load($modelName = '')
    {
        $path = MODELS_PATH . $modelName . '.php';

        if (!file_exists($path)) {
            ob_end_clean();
            die('Model <b>' . $modelName . '</b> not exists.');
        }

        include($path);
    }


}

?>