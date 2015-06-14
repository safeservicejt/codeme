<?php

class Database
{

    private static $dbConnect = '';

    private static $hasConnected = 'no';

    public static $dbType = 'mysqli';

    public static $tableName = '';

    public static $dbinfo = array();

    public static $dbName='';

    public static $totalQuery=0;

//    public static $fieldList = array();

    public static $error;


//
//    public function __set($varName = '', $varValue = '')
//    {
//        $this->fieldList[$varName] = $varValue;
//    }


    //  Object-Relational Mapping (ORM)

    public function getTotalQuery()
    {
        return self::$totalQuery;
    }

    public function getDbName()
    {
        return self::$dbName;
    }

    public function table($tableName = '')
    {

        $db = new DatabaseORM();

        $db->tableName = $tableName;

        return $db;

    }

    //  Object-Relational Mapping (ORM)


    public function connect($dbsortName = 'default')
    {
        global $db;

        if (self::$hasConnected == 'no') {

            if (!is_array($db[$dbsortName])) return false;

            self::$dbinfo = $db[$dbsortName];

            self::$dbType = $db[$dbsortName]['dbtype'];

            switch ($db[$dbsortName]['dbtype']) {
                case "mysqli":

                    $conn = new mysqli($db[$dbsortName]['dbhost'], $db[$dbsortName]['dbuser'], $db[$dbsortName]['dbpassword'], $db[$dbsortName]['dbname'], $db[$dbsortName]['dbport']);

//                    if (!$conn) Alert::make('Cant connect to your database.');


                    self::$dbConnect = $conn;

                    self::$hasConnected = 'yes';

                    self::$dbName=$db[$dbsortName]['dbname'];

                      if(isset($conn->connect_error[5]))
                      {
                        Log::error('Can not connect to your database. You must to edit file config.php now!');
                      }  

                    return $conn;

                    break;


                case "sqlserver":

                    $conn = DatabaseSqlserver::connect();

                    self::$error = DatabaseSqlserver::$error;

                    self::$dbConnect = $conn;

                    self::$hasConnected = 'yes';

                    return $conn;

                    break;

                case "mssql":

                    $conn = DatabaseMSSQL::connect();

//                    self::$error = DatabaseMSSQL::$error;

                    self::$dbConnect = $conn;

                    self::$hasConnected = 'yes';

                    return $conn;

                    break;


                case "pdo":

                    $conn = DatabasePDO::connect();

                    self::$dbConnect = $conn;

                    self::$hasConnected = 'yes';

                    return $conn;

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

 
    public function close($dbsortName = 'default')
    {
        global $db;

        if (!is_array($db[$dbsortName])) return false;

        self::$dbinfo = $db[$dbsortName];

        self::$dbType = $db[$dbsortName]['dbtype'];

        switch ($db[$dbsortName]['dbtype']) {

            case "mysqli":

                if(mysqli_close(self::$dbConnect))
                {
                    return true;
                }

                return false;
                break;
        }

    }



    public function query($queryStr = '', $objectStr = '')
    {
        switch (self::$dbType) {
            case "mysqli":

                self::$totalQuery++;

                $queryDB = self::$dbConnect->query($queryStr);

                // echo self::$dbConnect->error;

                self::$error = self::$dbConnect->error;

                if(isset(self::$error[5]))
                {
                    return false;
                }

                if (is_object($objectStr)) {
                    $objectStr($queryDB);
                }

                return $queryDB;

                break;

            case "sqlserver":

                $query = DatabaseSqlserver::query($queryStr, $objectStr = '');

                self::$error = DatabaseSqlserver::$error;

                return $query;

                break;

            case "mssql":

                $query = DatabaseMSSQL::query($queryStr, $objectStr = '');

                self::$error = DatabaseMSSQL::$error;

                return $query;

                break;

            case "pdo":

                $query = DatabasePDO::query($queryStr);

                return $query;

                break;

            case "mysql":


                break;
        }

    }

    public function nonQuery($queryStr = '', $objectStr = '')
    {
        switch (self::$dbType) {
            case "mysqli":

                $queryDB = self::$dbConnect->send_query($queryStr);

                // echo self::$dbConnect->error;

                self::$error = self::$dbConnect->error;

                if (is_object($objectStr)) {
                    $objectStr($queryDB);
                }

                return $queryDB;

                break;
        }

    }

    public function exec($queryStr = '')
    {
        switch (self::$dbType) {
            case "pdo":

                $query = DatabasePDO::exec($queryStr);

                break;

        }

    }

    public function fetch_assoc_all($queryDB, $objectStr = '', $fetchType = 'SQLSRV_FETCH_ASSOC')
    {
        $totalRows=self::num_rows($query);

        if(isset(self::$error[5]))
        {
            return false;
        }
        

        $resultData=array();

        while($row=self::fetch_assoc($query))
        {
            $resultData[]=$row;
        }

        if (is_object($objectStr)) {
            $objectStr($resultData);
        } 

        return $resultData;
    }
    public function fetch_array_all($queryDB, $objectStr = '', $fetchType = 'SQLSRV_FETCH_ASSOC')
    {
        
        $totalRows=self::num_rows($query);

        $resultData=array();

        while($row=self::fetch_array($query))
        {
            $resultData[]=$row;
        }

        if (is_object($objectStr)) {
            $objectStr($resultData);
        } 

        return $resultData;
    }

    public function fetch_assoc($queryDB, $objectStr = '', $fetchType = 'SQLSRV_FETCH_ASSOC')
    {
        switch (self::$dbType) {
            case "mysqli":

                if(isset(self::$error[5]))
                {
                    return false;
                }

                $row = $queryDB->fetch_assoc();

                if (is_object($objectStr)) {
                    $objectStr($row);
                }

                return $row;

                break;

            case "sqlserver":

                $row = DatabaseSqlserver::fetch_array($queryDB, $objectStr, $fetchType);

                return $row;

                break;

            case "mssql":

                $row = DatabaseMSSQL::fetch_array($queryDB, $objectStr, $fetchType);

                return $row;

                break;

            case "pdo":

                $row = DatabasePDO::fetch_assoc($queryDB);

                return $row;

                break;


        }

    }

    public function fetch_obj($queryDB)
    {
        switch (self::$dbType) {

            case "pdo":

                $row = DatabasePDO::fetch_obj($queryDB);

                return $row;

                break;
        }

    }

    public function fetch_array($queryDB, $objectStr = '', $fetchType = 'SQLSRV_FETCH_ASSOC')
    {
        switch (self::$dbType) {
            case "mysqli":

                $row = $queryDB->fetch_array();

                if (is_object($objectStr)) {
                    $objectStr($row);
                }

                return $row;

                break;

            case "sqlserver":

                $row = DatabaseSqlserver::fetch_array($queryDB, $objectStr, $fetchType);

                return $row;

                break;
            case "mssql":

                $row = DatabaseMSSQL::fetch_array($queryDB, $objectStr, $fetchType);

                return $row;

                break;

            case "pdo":

                $row = DatabasePDO::fetch_assoc($queryDB);

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

            case "sqlserver":

                $totalRows = DatabaseSqlserver::num_rows($queryDB, $objectStr);

                return $totalRows;

                break;
            case "mssql":

                $totalRows = DatabaseMSSQL::num_rows($queryDB, $objectStr);

                return $totalRows;

                break;

            case "pdo":

                $totalRows = DatabasePDO::num_rows($queryDB, $objectStr);

                return $totalRows;

                break;

        }

    }
    public function affected_rows($objectStr = '')
    {
        switch (self::$dbType) {
            case "mysqli":

                $totalRows = self::$dbConnect->affected_rows;

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

            case "sqlserver":

                $id = DatabaseSqlserver::insert_id($objectStr);

                return $id;

                break;
            case "mssql":

                $id = DatabaseMSSQL::insert_id($objectStr);

                return $id;

                break;
            case "pdo":

                $id = DatabasePDO::insert_id($objectStr);

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

    public function import($fileName = 'db.sql')
    {

        if (file_exists($fileName)) {

            Database::query("SET NAMES 'utf8';");


            $query = file_get_contents($fileName);

            preg_match_all('/CREATE.*?\;/is', $query, $creates);

            $total = count($creates[0]);

            for ($i = 0; $i < $total; $i++) {

                Database::query($creates[0][$i]);
            }

            preg_match_all('/INSERT.*?\;/is', $query, $creates);

            $total = count($creates[0]);

            for ($i = 0; $i < $total; $i++) {

                Database::query($creates[0][$i]);
            }

        }

        return false;

    }


}


?>