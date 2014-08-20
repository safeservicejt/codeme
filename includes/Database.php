<?php

class Database
{

    private static $dbConnect = '';

    private static $hasConnected = 'no';

    private static $dbType = 'mysqli';

    public function connect()
    {
        global $db;

        if (self::$hasConnected == 'no') {

            self::$dbType = $db['dbtype'];

            switch ($db['dbtype']) {
                case "mysqli":

                    $conn = new mysqli($db['dbhost'], $db['dbuser'], $db['dbpassword'], $db['dbname'], $db['dbport']);

//                    if (!$conn) Alert::make('Cant connect to your database.');

                    self::$dbConnect = $conn;

                    self::$hasConnected = 'yes';

                    break;

//                case "mysql":
//
//                    $conn = mysql_connect($db['dbhost'], $db['dbuser'], $db['dbpassword']);
//
//                    mysql_select_db($db['dbname']);
//
//                    self::$dbConnect = $conn;
//
//                    self::$hasConnected = 'yes';
//
//                    break;


            }
        }

    }

    public function query($queryStr = '', $objectStr = '')
    {
        switch (self::$dbType) {
            case "mysqli":

                $queryDB = self::$dbConnect->query($queryStr);

                if (is_object($objectStr)) {
                    $objectStr($queryDB);
                }

                return $queryDB;

                break;

            case "mysql":


                break;
        }

    }

    public function fetch_assoc($queryDB, $objectStr = '')
    {
        switch (self::$dbType) {
            case "mysqli":

                $row = $queryDB->fetch_assoc();

                if (is_object($objectStr)) {
                    $objectStr($row);
                }

                return $row;

                break;


        }

    }

    public function num_rows($queryDB, $objectStr = '')
    {
        switch (self::$dbType) {
            case "mysqli":

                $totalRows = $queryDB->num_rows;

                if (is_object($objectStr)) {
                    $objectStr($totalRows);
                }

                return $totalRows;

                break;

        }

    }

    public function insert_id($objectStr = '')
    {
        switch (self::$dbType) {
            case "mysqli":

                $id = self::$dbConnect->insert_id;

                if (is_object($objectStr)) {
                    $objectStr($id);
                }

                return $id;

                break;

        }

    }

    public function hasError($objectStr = '')
    {
        switch (self::$dbType) {
            case "mysqli":

                $errorStr = self::$dbConnect->error;

                if (isset($errorStr[5])) {
                    if (is_object($objectStr)) {
                        $objectStr($errorStr);
                    }

                    return $errorStr;
                }

                return false;


                break;

        }
    }


}

class DB extends Database
{
}

?>