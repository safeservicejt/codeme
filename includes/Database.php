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


            }
        }

    }

    public function query($queryStr = '', $objectStr = '')
    {
        $queryDB = self::$dbConnect->query($queryStr);

        if (is_object($objectStr)) {
            $objectStr($queryDB);
        }

        return $queryDB;
    }

    public function fetch_assoc($queryDB, $objectStr = '')
    {
        $row = $queryDB->fetch_assoc();

        if (is_object($objectStr)) {
            $objectStr($row);
        }

        return $row;
    }

    public function num_rows($queryDB, $objectStr = '')
    {
        $totalRows = $queryDB->num_rows;

        if (is_object($objectStr)) {
            $objectStr($totalRows);
        }

        return $totalRows;
    }


}

class DB extends Database
{
}

?>