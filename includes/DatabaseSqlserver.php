<?php

class DatabaseSqlserver
{

    public static $dbConnect = '';

    public static $error = '';

    public static $insertID = 0;

    public function connect()
    {
        global $db;

        $serverName = $db['dbhost'] . ', ' . $db['dbport']; //serverName\instanceName, portNumber (default is 1433)
        $connectionInfo = array("Database" => $db['dbname'], "UID" => $db['dbuser'], "PWD" => $db['dbpass']);
        $conn = sqlsrv_connect($serverName, $connectionInfo);

        if ($conn) {
            self::$dbConnect = $conn;

            return $conn;
        } else {
            self::$error = sqlsrv_errors();

            return false;
        }


    }

    public function query($queryStr = '', $objectStr = '')
    {

        $queryDB = sqlsrv_query(self::$dbConnect, $queryStr);

        if (preg_match('/insert into/i', $queryDB)) {
            sqlsrv_next_result($queryDB);

            sqlsrv_fetch($queryDB);

            self::$insertID = sqlsrv_get_field($queryDB, 0);
        }

        if ($queryDB) {
            if (is_object($objectStr)) {
                $objectStr($queryDB);
            }

//            sqlsrv_free_stmt($queryDB);

            return $queryDB;
        } else {
            self::$error = sqlsrv_errors();

            return false;
        }


    }

    public function fetch_array($queryDB = '', $objectStr = '', $fetchType = 'SQLSRV_FETCH_ASSOC')
    {
        $row = sqlsrv_fetch_array($queryDB, $fetchType);


        if (is_object($objectStr)) {
            $objectStr($row);
        }

        return $row;
    }

    public function num_rows($queryDB = '', $objectStr = '')
    {
        $numRows = sqlsrv_num_rows($queryDB);

        if (is_object($objectStr)) {
            $objectStr($numRows);
        }

        return $numRows;

    }

    public function insert_id($objectStr = '')
    {
//        sqlsrv_next_result($queryDB);
//
//        sqlsrv_fetch($queryDB);
//
//        $id = sqlsrv_get_field($queryDB, 0);
//
//        if ((int)$id == 0) {
//            $id = self::$insertID;
//        }

        $id = self::$insertID;

        if (is_object($objectStr)) {
            $objectStr($id);
        }

        return $id;
    }


}

?>