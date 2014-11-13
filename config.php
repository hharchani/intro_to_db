<?php

#####################################################################
// The following lines are for error reporting. Remove on production.
error_reporting(E_ALL);
ini_set("display_errors", 1);// */
#####################################################################

define("DB_HOST", "localhost");
define("DB_USER", "intro");
define("DB_PASS", "dbproject");
define("DB_NAME", "intro_to_db");

class InsertEntity {
    public
    $keysArray = array(),
    $valuesArray = array();

    function getKeys() {
        return "(" . join(',', $this->keysArray) .")";
    }

    function getValues() {
        return "(" . join(",", $this->valuesArray) .")";
    }
}

class InsertSingleEntity extends InsertEntity {
    function add($key, $value) {
        $this->keysArray[] = $key;
        if (gettype($value) == "string") {
            $this->valuesArray[] = '"'.$value.'"';
        }
        else {
            $this->valuesArray[] = $value;
        }
        return $this;
    }
}

class InsertMultiEntity extends InsertEntity{
    private
    $keyCount;

    function __construct($array) {
        if (gettype($array) == "array") {
            $this->keysArray = $array;
        }
        else {
            $this->keysArray = func_get_args();
        }
        $this->keysCount = count($this->keysArray);
    }

    function add($array) {
        if (gettype($array) == "array") {
            $this->valuesArray[] = "(" . join(",", $array) . ")";
        }
        else {
            $valueCount = func_num_args();
            if ($valueCount != $this->keysCount) {
                echo ("Insufficient values provided");
                return this;
            }
            $this->valuesArray[] = "(" . join(",", func_get_args()) . ")";
        }
        return $this;
    }
    function getValues() {
        return join(",", $this->valuesArray);
    }
}

class DAL {
    public $mysqli;
    function __construct() {
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $mysqli->connect_error);
        }
    }
    function insertDataIntoTable($table, $insertEntity) {
        $res = $this->mysqli->query("INSERT INTO `".$table."` ".$insertEntity->getKeys()." VALUES ".$insertEntity->getValues());
        if ( !$res ) {
            echo "Some error occured". $this->mysqli->error;
        }
        return $this->mysqli;
    }
    function fetchDataFromTable($table, $arrayOfColumns, $whereCondition) {
        $columns = join(", ", $arrayOfColumns);
        $result = $this->mysqli->query("SELECT {$columns} FROM {$table} WHERE ".$whereCondition);
        $rows = array();
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }
        return $rows;
    }
    function fetchDataAsJson($table, /* unique */ $keyCol, $valCol, $whereCondition) {
        $result = $this->mysqli->query("SELECT {$keyCol}, {$valCol} FROM {$table} WHERE {$whereCondition} LIMIT 20");
        echo ("SELECT {$keyCol}, {$valCol} FROM {$table} WHERE ".$whereCondition);
        $rows = array();
        if (! $result ) {
            echo gettype($result->fetch_assoc);
            while($row = $result->fetch_assoc()) {
                $rows[$row[$keyCol]] = $row[$valCol];
            }
            return json_encode($rows);
        }
        else {
            return json_encode( array() );
        }
    }
    function query($sql) {
        return $this->mysqli->query($sql);
    }
}
$DB = new DAL();


