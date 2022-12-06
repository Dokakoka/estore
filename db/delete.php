<?php
require_once "DBConfig.php";

function delete($table, $condition) {
    $sql = "DELETE FROM $table Where $condition";
    $connection = createConnection();
    mysqli_query($connection, $sql);
    if(mysqli_affected_rows($connection)>0) {
        return true;
    } else {
        return false;
    }
}
?>