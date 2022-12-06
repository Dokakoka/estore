<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php" ?>
<?php
session_destroy();
redirect(URL."index.php");
?>