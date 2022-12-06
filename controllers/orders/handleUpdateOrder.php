<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."core/validations.php"; ?>
<?php require_once ROOT."db/update.php"; ?>
<?php require_once ROOT."db/delete.php"; ?>

<?php

if(checkRequestMethod("GET") && checkGetValue("client_id")) {

    $data = [
        "order_status"=>1,
    ];
    $res = update("orders", $data, "client_id=".$_GET['client_id']);
    if($res) {
        $_SESSION['db_success'] = "Successfully Purchased";
        unset($_SESSION['auth'][2]);
        unset($_SESSION['auth'][3]);
        redirect(URL."pages/orders/client_order.php?client_id=".$_GET['client_id']);
        die;
    } else {
        $_SESSION['db_error'] = "Failed To Purchase";
        redirect(URL."pages/orders/client_order.php?client_id=".$_GET['client_id']);
        die;
    }

}

?>