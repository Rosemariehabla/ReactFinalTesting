<?php
function Connect(){
    $host = "localhost";
    $user = "root";  
    $pass = "";       
    $db   = "visitor_logging"; // database name

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
