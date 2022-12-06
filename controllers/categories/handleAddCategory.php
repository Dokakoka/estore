<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."core/validations.php"; ?>
<?php require_once ROOT."db/add.php"; ?>

<?php

$errors = [];

if(checkRequestMethod("POST") && checkPostValue("name")) {

    foreach($_POST as $key=>$value) {
        $$key = inputHandler($value);
    }

    if(!checkEmpty($name)) {
        $errors[] = "Category Name is required";
    } elseif(!minLen($name, 2)) {
        $errors[] = "Category Name must be greater than 2 chars";
    } elseif(!maxLen($name, 50)) {
        $errors[] = "Category Name must be lower than 50 chars";
    }

    if(empty($errors)) {
        $data = [
            "name"=>$name,
        ];
        $res = insert("categories", $data);
        if($res) {
            $_SESSION['db_success'] = "Successfully Added a new Category";
            redirect(URL."pages/categories/addCategory.php");
        } else {
            $_SESSION['db_error'] = "Failed To Add a new Category";
            redirect(URL."pages/categories/addCategory.php");
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect(URL."pages/categories/addCategory.php");
    }

}

?>