<?php

static $root_path = 'D:\wamp\htdocs\project\2014\codeme/';
static $root_url = 'http://test.vn/project/2014/codeme/';

define("ROOT_PATH", $root_path);

define("ROOT_URL", $root_url);

define("APP_PATH", $root_path . 'application/');

define("APP_URL", $root_url . 'application/');

define("CONTROLLERS_PATH", APP_PATH . 'controllers/');

define("MODELS_PATH", APP_PATH . 'models/');

define("VIEWS_PATH", APP_PATH . 'views/');

define("CACHES_PATH", APP_PATH . 'caches/');

define("LANG_PATH", APP_PATH . 'lang/');

define("CONTROLLERS_URL", APP_URL . 'controllers/');

define("MODELS_URL", APP_URL . 'models/');

define("VIEWS_URL", APP_URL . 'views/');

define("LANG_URL", APP_URL . 'lang/');

define("INCLUDES_PATH", ROOT_PATH . 'includes/');

$uri = isset($_GET['load']) ? $_GET['load'] : '';

//Setting database

// Support DbType: mysqli|sqlserver|pdo|mssql

//Default or you can custom db short name
$db['default'] = array(

    "dbtype" => "mysqli",

    "dbhost" => "localhost",

    "dbport" => "3306",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "2014_codeme_test"

);


/*
//Add more database

//$db['testdb']:  testdb is custom short name of database


$db['testdb'] = array(

    "dbtype" => "sqlserver",

    "dbhost" => "serverName\sqlexpress",

    "dbport" => "1433",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "2014_testdb"

);

$db['blogmssql'] = array(

    "dbtype" => "mssql",

    "dbhost" => "localhost",

    "dbport" => "1433",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "2014_wordpress"

);

$db['blog_api'] = array(

    "dbtype" => "pdo",

    "protocol" => "pgsql",

    "dbhost" => "localhost",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "2014_wordpress"

);

*/

//Function autoload
/*
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
function mainClassess($className) {

    if(file_exists(INCLUDES_PATH . $className . '.php'))
    {
        require INCLUDES_PATH . $className . '.php';       
    }
    
}
// function extendsClassess($className) {
//     if(file_exists(INCLUDES_PATH .'ac/' . $className . '.php'))
//     {
//         require INCLUDES_PATH .'ac/'. $className . '.php';       
//     }
   
// }

spl_autoload_register('mainClassess');
// spl_autoload_register('extendsClassess');

// function __autoload($className)
// {
//     if (file_exists(INCLUDES_PATH . $className . '.php')) {

//         require INCLUDES_PATH . $className . '.php';     

//         return true;
//     }

//     return false;
// }

function load_page_not_found()
{
    ob_end_clean();

    View::make('page_not_found');

    die();

}

?>