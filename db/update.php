<?php
require_once ROOT."db/DBConfig.php";

function update($table, $data, $condition) {
    $columns="";
    $values="";
    $query = "";
    foreach ($data as $key =>$value) {
        $columns = "$key";
        $values="'$value'";
        $query .= "$columns=$values, ";
    }
    $query = rtrim($query, ", ");

    $sql = "Update $table SET $query Where $condition";
    $connection = createConnection();
    mysqli_query($connection, $sql);
    if(mysqli_affected_rows($connection)>=0) {
        return true;
    } else {
        return false;
    }
}
?>