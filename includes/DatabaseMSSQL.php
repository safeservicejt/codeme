<?php

class DatabaseMSSQL
{

    public static $dbConnect = '';

    public static $error = '';

    public static $insertID = 0;


    public function connect()
    {
        global $db;

        $serverName = $db['dbhost'] . ', ' . $db['dbport']; //serverName\instanceName, portNumber (default is 1433)

        $conn = mssql_connect($serverName, $db['dbuser'], $db['dbpass']);

        $selected = mssql_select_db($db['dbname'], $conn);

        if ($selected) {
            self::$dbConnect = $conn;

            return $conn;
        } else {
            self::$error = 'Can not connect to database.';

            return false;
        }


    }

    public function query($queryStr = '', $objectStr = '')
    {
        $queryDB = mssql_query(self::$dbConnect, $queryStr);

        if (preg_match('/insert into/i', $queryDB)) {
            mssql_next_result($queryDB);

            $row = mssql_fetch_row($queryDB);

            self::$insertID = $row[0];
        }

        if (is_object($objectStr)) {
            $objectStr($queryDB);
        }

        return $queryDB;

    }

    public function fetch_array($queryDB = '', $objectStr = '', $fetchType = 'MSSQL_ASSOC')
    {
        $row = mssql_fetch_array($queryDB, $fetchType);

        if (is_object($objectStr)) {
            $objectStr($row);
        }

        return $row;
    }

    public function num_rows($queryDB = '', $objectStr = '')
    {
        $numRows = mssql_num_rows($queryDB);

        if (is_object($objectStr)) {
            $objectStr($numRows);
        }

        return $numRows;

    }

    public function insert_id($objectStr = '')
    {

        $id = self::$insertID;

        if (is_object($objectStr)) {
            $objectStr($id);
        }

        return $id;
    }

}

?>