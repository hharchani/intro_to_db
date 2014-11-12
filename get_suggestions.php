<?php
    include("config.php");
    
    if ( isset($_POST["suggest_wholesaler"]) ) {
        $start = $_POST["suggest_wholesaler"];
        echo $DB->fetchDataAsJson("wholesaler", "id", "name", "name LIKE {$start}%");
    }
?>