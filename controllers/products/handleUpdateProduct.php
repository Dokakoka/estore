<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."core/validations.php"; ?>
<?php require_once ROOT."db/update.php"; ?>

<?php

$errors = [];

if(checkRequestMethod("POST") && checkPostValue("name")) {

    foreach($_POST as $key=>$value) {
        $$key = inputHandler($value);
    }

    if(!checkEmpty($name)) {
        $errors[] = "Product Name is required";
    } elseif(!minLen($name, 2)) {
        $errors[] = "Product Name must be greater than 2 chars";
    } elseif(!maxLen($name, 50)) {
        $errors[] = "Product Name must be lower than 50 chars";
    }

    if(!checkEmpty($description)) {
        $errors[] = "Product Description is required";
    } elseif(!minLen($description, 10)) {
        $errors[] = "Product Name must be greater than 10 chars";
    } elseif(!maxLen($description, 300)) {
        $errors[] = "Product Description must be lower than 300 chars";
    }

    if(!checkEmpty($price)) {
        $errors[] = "Product Price is required";
    } elseif(!checkNum($price)) {
        $errors[] = "Product Price must be number";
    } elseif(!minNum($price, 0)) {
        $errors[] = "Product Price must be greater than 0$";
    } elseif(!maxNum($price, 10000)) {
        $errors[] = "Product Price must be lower than 10000$";
    }

    if(!checkEmpty($qty)) {
        $errors[] = "Product QTY is required";
    } elseif(!checkNum($qty)) {
        $errors[] = "Product QTY must be a number";
    } elseif(!minNum($qty, 0)) {
        $errors[] = "Product QTY must be greater than 0";
    } elseif(!maxNum($qty, 1000)) {
        $errors[] = "Product QTY must be lower than 1000";
    }

    $file_handle = fileHandling($_FILES['image'], "products");
    if($file_handle[0] == false) {
        $errors[] = $file_handle[1];
    }
    if(empty($errors)) {
        $data = [
            "name"=>$name,
            "description"=>$description,
            "price"=>$price,
            "qty"=>$qty,
            "img"=>$file_handle[1],
            "user_id"=>$_SESSION['auth'][0],
            "category_id"=>$category
        ];
        $res = update("products", $data, "id=".$_GET['id']);
        if($res) {
            $_SESSION['db_success'] = "Successfully Update the Product";
            redirect(URL."pages/products/updateProduct.php?id=".$_GET['id']);
            die;
        } else {
            $_SESSION['db_error'] = "Failed To Add a new Product";
            redirect(URL."pages/products/updateProduct.php?id=".$_GET['id']);
            die;
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect(URL."pages/products/updateProduct.php?id=".$_GET['id']);
        die;
    }

}

?>