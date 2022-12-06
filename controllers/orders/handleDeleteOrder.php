<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."db/select.php"; ?>
<?php require_once ROOT."db/update.php"; ?>
<?php require_once ROOT."db/delete.php"; ?>

<?php
if(checkRequestMethod("GET") && checkGetValue("order_id")) {
    $id = $_GET["order_id"];
    $product_id = select("product_id, qty", "orders", "id=".$id);
    $product_data = select("qty", "products", "id=".$product_id[0]['product_id']);
    $diffQty = $product_data[0]['qty'] + $product_id[0]['qty'];
    $res = update("products", ["qty"=>$diffQty], "id=".$product_id[0]['product_id']);
    delete("orders", "id=$id");
    redirect(URL."pages/orders/client_order.php?client_id=".$_GET['client_id']);
} else {
    redirect(URL."pages/clients/index.php");
}
?>