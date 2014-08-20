<?php


function __autoload($className)
{
    if (file_exists(INCLUDES_PATH . $className . '.php')) {
        require_once INCLUDES_PATH . $className . '.php';
        return true;
    }
    return false;
}

function load_page_not_found()
{
    ob_end_clean();

    View::make('page_not_found');

    die();

}


?>