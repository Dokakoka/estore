<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."db/delete.php"; ?>

<?php
if(checkRequestMethod("GET") && checkGetValue("id")) {
    $id = $_GET["id"];
    delete("users", "id=$id");
    unlink(ROOT."assets/uploads/users/".$_GET['img']);
    redirect(URL."pages/users/index.php");
} else {
    redirect(URL."pages/users/index.php");
}
?>