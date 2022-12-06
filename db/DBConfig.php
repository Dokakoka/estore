<?php

function createConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "estore";
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn) {
        die;
    } else {
        return $conn;
    }
}

?>