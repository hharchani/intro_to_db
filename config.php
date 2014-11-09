<?php

#####################################################################
// The following lines are for error reporting. Remove on production.
error_reporting(E_ALL);
ini_set('display_errors', 1);// */
#####################################################################

define('DB_HOST', 'localhost');
define('DB_USER', 'intro');
define('DB_PASS', 'dbproject');
define('DB_NAME', 'intro_to_db');

$DB=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    $DB=false;
}

class InsertEntity {
    public
    $datatypeFormat = "",
    $keyArray = array(),
    $valueArray = array();
    
    function __construct() {
    }
    
    function add($key, $val, $datatype) {
        $this->datatypeFormat .= $datatype;
        $this->keyArray[] = $key;
        $this->valueArray[] = $val;
    }
    function getValues($query) {
        $starting = array($query, $this->datatypeFormat);
        $refs = array();
        foreach($this->valueArray as $key => $value)
            $refs[$key] = &$this->valueArray[$key];
        return array_merge($starting, $refs);
    }
    function getKeys() {
        return join(',', $this->keyArray);
    }
    function getQuestionMarks() {
        $c = count($this->keyArray);
        return substr( str_repeat('?,', $c) , 0, $c*2-1);
    }
}

function insertDataIntoTable($table, $insertEntity) {
    global $DB;
    $query = mysqli_prepare($DB, 'INSERT INTO `'.$table.'` ('.$insertEntity->getKeys().') VALUES('.$insertEntity->getQuestionMarks().')');
    
    call_user_func_array("mysqli_stmt_bind_param", $insertEntity->getValues($query));
    
    if ( !mysqli_stmt_execute($query) ) {
        die("Some error occurred");
    }
}
