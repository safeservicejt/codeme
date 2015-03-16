<?php

class DatabaseMongodb
{
    public static $dbConnect = '';

    public static $error = '';

    public static $insertID = 0;

    public static $protocol = 'mongodb';

    private static $runQuery = 'no';

    public function connect($keyName='default')
    {
        global $db;

        self::$protocol = $db[$keyName]['dbtype'];

        $conn = new MongoClient($db[$keyName]['dbhost']);

        $db_name=$db[$keyName]['dbname'];

        self::$dbConnect = $conn->$db_name;        

        return $conn;

    }

    public function insert($collection_name,$values)
    {
        $collection = self::$dbConnect->$collection_name;
        $collection->insert($values);
    }

    public function delete($collection_name,$condition)
    {
        $collection = self::$dbConnect->$collection_name;
        $collection->remove($condition);
    }

    public function update($collection_name,$condition,$newdata)
    {
        $collection = self::$dbConnect->$collection_name;
        $collection->update($condition,$newdata);
    }

    public function findOne($collection_name,$condition,$field_name)
    {
        $collection = self::$dbConnect->$collection_name;
        $res = $collection->findOne($condition,$field_name);
        return $res;
    }

    public function count($collection_name,$condition)
    {
        $collection = self::$dbConnect->$collection_name;
        $res = $collection->count($condition);
        return $res;
    }

    public function getMax($collection_name,$field_name)
    {
        $collection = self::$dbConnect->$collection_name;
        $res = $collection->find(array(),$field_name)->sort(array("_id"=>-1))->limit(1);
    
        foreach($res as $v)
        {
            return($v['id']);
        }
    }

    public function find($collection_name,$field_name,$condition=null)
    {
        $collection = self::$dbConnect->$collection_name;
        $res = $collection->find($condition,$field_name);   
        $output = "";
        $co=0;
        foreach($res as $v)
        {
            foreach($field_name as $p=>$k)
            {
                $output[$co][$p] = $v[$p];  
            }
        $co++;
        }
        return $output;
    }



}


?>