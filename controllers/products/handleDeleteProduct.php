<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."db/delete.php"; ?>

<?php
if(checkRequestMethod("GET") && checkGetValue("id")) {
    $id = $_GET["id"];
    delete("products", "id=$id");
    unlink(ROOT."assets/uploads/products/".$_GET['img']);
    redirect(URL."pages/products/index.php");
} else {
    redirect(URL."pages/products/index.php");
}
?>