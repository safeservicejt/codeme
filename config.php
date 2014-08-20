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

define("CONTROLLERS_URL", APP_URL . 'controllers/');

define("MODELS_URL", APP_URL . 'models/');

define("VIEWS_URL", APP_URL . 'views/');

define("INCLUDES_PATH", ROOT_PATH . 'includes/');

//Connect to database


static $db = array(

    "dbtype" => "mysqli",

    "dbhost" => "localhost",

    "dbport" => "3306",

    "dbuser" => "root",

    "dbpassword" => "",

    "dbname" => "2014_project_codeme"

);

//$db = new mysqli($dbhost, $dbuser, $dbpass,$dbname);
//$db->query("SET NAMES 'utf8';");


?>