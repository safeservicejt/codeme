<?php

class View
{

    public function make($viewName = '', $viewData = array())
    {
        if (preg_match('/\./i', $viewName)) {
            $viewName = str_replace('.', '/', $viewName);
        }

        $path = VIEWS_PATH . $viewName . '.php';

        if (!file_exists($path)) {

            ob_end_clean();

            include(VIEWS_PATH . 'page_not_found.php');

            die();
        }

        $total_data = count($viewData);

        if ($total_data > 0) extract($viewData);

        include($path);
    }

    public function load($viewName = '', $viewData = array())
    {
        self::make($viewName, $viewData);
    }


}

?>