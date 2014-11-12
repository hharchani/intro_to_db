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

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

class InsertEntity {
    public
    $valuesArray = array();
    private
    $keysCount,
    $keys;
    
    function __construct($array) {
        if (gettype($array) == "array") {
            $this->keys = $array;
        }
        else {
            $this->keys = func_get_args();
        }
        $this->keysCount = count($this->keys);
    }
    
    function add() {
        $valueCount = func_num_args();
        if ($valueCount != $this->keysCount) {
            die("Insufficient values provided");
        }
        $this->valuesArray[] = "(" . join(",", func_get_args()) . ")";
        return this;
    }
    
    function getKeys() {
        return "(" . join(',', $this->keys) .")";
    }
    
    function getValues($query) {
        return join(",", $this->valuesArray);
    }
}

class OperationOn {
    private $table, $todo;
    
    function __construct($tableName) {
        $this->table = $tableName;
    }
    
    function end() {
        call_user_func(array(this, $this->todo));
    }
    
    private $insertEntity;
    private function insert() {
        global $mysqli;
        $res = $mysqli->query("INSERT INTO `{$this->table}` {$this->insertEntity->getKeys()} VALUES {$this->insertEntity->getValues()}");
        
        if ( !$res ) {
            die("Some error occurred, could not insert data");
        }
    }
    
    function insertData($insertEntity) {
        $this->insertEntity = $insertEntity;
        $this->todo = "insert";
    }
    
    function andOptions($column) {
        echo "<option value='".$id."'>".$option."</option>";
        fromTable("table")->getColumns("id")->asAttributes("value")->withContent("name")->wrapBy("option");
        fromTable("table")->getColumns("a", "b", "c")->asAttributes("d", "e", "f")->withContent("h")->wrapBy("tag");
    }
    
    private
    $columns,
    $attributes,
    $content = false,
    $tag = "span";
    function getColumns() {
        $this->columns = func_get_args();
        return $this;
    }
    function asAttributes() {
        if (count($this->columns) != func_num_args()) {
            die("Insufficient values provided");
        }
        $this->attributes = func_get_args();    
        return $this;
    }
    function withContent($col) {
        $this->content = $col;
        return $this;
    }
    function wrappedBy($tag) {
        $this->tag = $tag;
        return $this;
    }
}

class _start {
    function fromTable($tableName) {
        return new OperationOn($tableName);
    }
    function inTable($tableName) {
        return new OperationOn($tableName);
    }
}

function start() {
    return new _start();
}