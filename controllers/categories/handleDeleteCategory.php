<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."db/delete.php"; ?>

<?php
if(checkRequestMethod("GET") && checkGetValue("id")) {
    $id = $_GET["id"];
    delete("categories", "id=$id");
    redirect(URL."pages/categories/index.php");
} else {
    redirect(URL."pages/categories/index.php");
}
?>