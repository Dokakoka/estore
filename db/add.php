<?php 
require_once ROOT."db/DBConfig.php";

function insert($table, $data) {
    $columns="";
    $values="";
    foreach ($data as $key =>$value) {
        $columns .= "$key,";
        $values.="'$value',";
    }
    $columns = rtrim($columns, ",");
    $values = rtrim($values, ",");

    $sql = "INSERT INTO $table ($columns) Values ($values)";
    $connection = createConnection();
    mysqli_query($connection, $sql);
    if(mysqli_affected_rows($connection)>0) {
        return true;
    } else {
        return false;
    }
}





?>