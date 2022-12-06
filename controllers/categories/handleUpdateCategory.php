<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."core/validations.php"; ?>
<?php require_once ROOT."db/update.php"; ?>
<?php
if(!isset($_GET['id'])) {
    redirect(URL."pages/categories/updateCategory.php");
}
?>
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
        $id = $_GET["id"];
        
        $res = update("categories", $data, "id=$id");
        if($res) {
            $_SESSION['db_success'] = "Successfully Update Category";
            redirect(URL."pages/categories/updateCategory.php");
        } else {
            $_SESSION['db_error'] = "Failed To UPDATE Category";
            redirect(URL."pages/categories/updateCategory.php");
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect(URL."pages/categories/updateCategory.php");
    }

}
?>