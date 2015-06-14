<?php

class DatabaseMysqli
{
    public static $dbConnect = '';

    private static $hasConnected = 'no';

    public static $error = '';
    
    public static $tableName = '';

    public static $dbinfo = array();

    public static $insertID = 0;

    public static $protocol = 'mysqli';

    private static $runQuery = 'no';

    public function connect()
    {
        global $db;

        self::$protocol = $db['protocol'];

        $conn = new mysqli($db[$dbsortName]['dbhost'], $db[$dbsortName]['dbuser'], $db[$dbsortName]['dbpassword'], $db[$dbsortName]['dbname'], $db[$dbsortName]['dbport']);

        self::$dbConnect = $conn;

        return $conn;

    }

    public function query($queryStr = '', $objectStr = '')
    {

        $queryDB = self::$dbConnect->query($queryStr);

        // echo self::$dbConnect->error;

        self::$error = self::$dbConnect->error;

        if (is_object($objectStr)) {
            $objectStr($queryDB);
        }

        return $queryDB;

    }
    public function nonQuery($queryStr = '', $objectStr = '')
    {
        $queryDB = self::$dbConnect->send_query($queryStr);

        // echo self::$dbConnect->error;

        self::$error = self::$dbConnect->error;

        if (is_object($objectStr)) {
            $objectStr($queryDB);
        }

        return $queryDB;

    }

    public function close($dbsortName = 'default')
    {
        global $db;

        if (!is_array($db[$dbsortName])) return false;

        if(mysqli_close(self::$dbConnect))
        {
            return true;
        }

        return false;

    }



}


?>