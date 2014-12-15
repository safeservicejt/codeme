<?php

class DatabaseORM
{
    public static $fieldList = array();


    function __construct($tableName='')
    {
        $this->tableName = $tableName;

        return $this;
    }


    public function __set($varName = '', $varValue = '')
    {
        $this->fieldList[$varName] = $varValue;
    }

    public function table($tableName = '')
    {

        $this->tableName = $tableName;

        return $this;

    }
    public function InsertOnSubmit($listFieldInsert = '')
    {
//        $freshConnnect=$this->fieldList['dbConnect'];

        $fieldList = $this->fieldList;

        $tableName = $fieldList['tableName'];

        unset($fieldList['dbConnect'], $fieldList['hasConnected'], $fieldList['tableName'], $fieldList['dbType'], $fieldList['error']);

        if (is_array($listFieldInsert)) {
            $fieldList = $listFieldInsert;
        }

        $listFieldNames = array_keys($fieldList);

        $listFieldValues = array_values($fieldList);

        $mergeField = implode(',', $listFieldNames);

        $mergeValue = "'" . implode("','", $listFieldValues) . "'";

        $queryStr = "INSERT INTO $tableName($mergeField) VALUES($mergeValue)";

        Database::query($queryStr);

        $insert_id = Database::insert_id();

        return $insert_id;
    }

    public function SubmitChanges()
    {
        $fieldList = $this->fieldList;

        $tableName = $fieldList['tableName'];

        $setWhere = $this->genWhere();

        unset($fieldList['dbConnect'], $fieldList['hasConnected'], $fieldList['tableName'], $fieldList['dbType'], $fieldList['whereName'], $fieldList['whereValue'], $fieldList['error']);


        $listFieldNames = array_keys($fieldList);

        $listFieldValues = array_values($fieldList);

        $totalField = count($listFieldNames);

        $setFields = '';

        for ($i = 0; $i < $totalField; $i++) {
            $setFields = $setFields . $listFieldNames[$i] . "='" . $listFieldValues[$i] . "', ";

        }

        $setFields = substr($setFields, 0, strlen($setFields) - 2);

        $quertStr = "UPDATE $tableName SET $setFields WHERE $setWhere";

        Database::query($quertStr);

    }


    public function where($fieldName = '', $fieldValue = '')
    {
        if (is_array($fieldName)) {
            $totalField = count($fieldName);

            $listKeyNames = array_keys($fieldName);

            for ($i = 0; $i < $totalField; $i++) {

                $fName = $listKeyNames[$i];

                $this->where[$fName] = $fieldName[$fieldValue];

            }


        } else {
            $this->where[$fieldName] = $fieldValue;
        }


//        $this->whereName = $fieldName;
//        $this->whereValue = $fieldValue;

        return $this;
    }

    private function genWhere()
    {
        $totalField = count($this->where);

        $listKeyNames = array_keys($this->where);

        $listKeyValues = array_values($this->where);

        $strWhere = '';

        for ($i = 0; $i < $totalField; $i++) {
            $strWhere .= $listKeyNames[$i] . "='" . $listKeyValues[$i] . "' AND ";
        }

        $strWhere = substr($strWhere, 0, strlen($strWhere) - 4);

        return $strWhere;

    }

    public function DeleteOnSubmit()
    {
        $fieldList = $this->fieldList;

        $tableName = $fieldList['tableName'];

        $setWhere = $this->genWhere();

        unset($fieldList['dbConnect'], $fieldList['hasConnected'], $fieldList['tableName'], $fieldList['dbType'], $fieldList['whereName'], $fieldList['whereValue'], $fieldList['error']);

        $quertStr = "delete from $tableName where $setWhere";

        Database::query($quertStr);
    }

    //  Object-Relational Mapping (ORM)


}


?>