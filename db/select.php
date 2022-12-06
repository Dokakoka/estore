<?php
require_once ROOT."db/DBConfig.php";

function select($columns, $table, $condition){
    $connection = createConnection();
    $query = mysqli_query($connection, "SELECT $columns FROM $table Where $condition");
    $data = [];
    while($row = mysqli_fetch_assoc($query)) {
        $data[]= $row;
    }
    return $data;
}
?>