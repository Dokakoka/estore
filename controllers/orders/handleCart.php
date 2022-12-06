<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."core/validations.php"; ?>
<?php require_once ROOT."db/add.php"; ?>
<?php require_once ROOT."db/select.php"; ?>
<?php require_once ROOT."db/update.php"; ?>

<?php

$errors = [];

if(checkRequestMethod("POST") && checkPostValue("qty")) {
    $qty = $_POST['qty'];
    $client_id = $_GET['client_id'];
    $product_id = $_GET['product_id'];
    $data = [
        "qty"=>$qty,
        "client_id"=>$client_id,
        "product_id"=>$product_id
    ];

    $product_data = select("*", "products", "id=".$product_id);
    $client_order_data = select("*", "orders", "client_id=".$client_id." AND product_id=".$product_id." AND order_status=0");
    
    if(empty($client_order_data)) {
        if($qty > $product_data[0]['qty']) {
            $_SESSION['db_error'] = "There is only ".$product_data[0]['qty']." items left";
            redirect(URL."pages/products/client_products.php?client_id=".$client_id);
        } else {
            $diffQTY = $product_data[0]['qty']- $qty;
            $res = insert("orders", $data);
            $pro = update("products", ["qty"=>$diffQTY], "id=".$product_id);
            $_SESSION['db_success'] = "Item Added to your cart";
            redirect(URL."pages/products/client_products.php?client_id=".$client_id);
        }
    } else {
        $diffQTY = $product_data[0]['qty']- $qty;
        $cartQty = $client_order_data[0]['qty'] + $qty;
        if($qty > $product_data[0]['qty']) {
            $_SESSION['db_error'] = "There is only ".$product_data[0]['qty']." items left";
            redirect(URL."pages/products/client_products.php?client_id=".$client_id);
        } else {
            $res = update("orders", ["qty"=>$cartQty], "id=".$client_order_data[0]['id']);
            $pro = update("products", ["qty"=>$diffQTY], "id=".$product_id);
            $_SESSION['db_success'] = "Item Added to your cart";
            redirect(URL."pages/products/client_products.php?client_id=".$client_id);
        }
    }

    // $check = select("*", "orders", "client_id=".$client_id." and product_id=".$product_id);

        // $res = insert("orders", $data);
        // redirect(URL."pages/products/client_products.php?client_id=".$client_id);
}