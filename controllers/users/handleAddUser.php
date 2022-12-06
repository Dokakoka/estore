<?php require_once "../../core/config.php"; ?>
<?php require_once ROOT."core/functions.php"; ?>
<?php require_once ROOT."core/validations.php"; ?>
<?php require_once ROOT."db/add.php"; ?>
<?php require_once ROOT."db/select.php"; ?>

<?php 
$all_users = select("email", "users", 1);
?>

<?php

$errors = [];

if(checkRequestMethod("POST") && checkPostValue("name")) {

    foreach($_POST as $key=>$value) {
        $$key = inputHandler($value);
    }

    if(!checkEmpty($name)) {
        $errors[] = "Username is required";
    } elseif(!minLen($name, 3)) {
        $errors[] = "Username must be greater than 3 chars";
    } elseif(!maxLen($name, 100)) {
        $errors[] = "Username must be lower than 100 chars";
    }

    foreach($all_users as $user) {
        if($email == $user['email']) {
            $errors[] = "Duplicated email";
        }
    }

    if(!checkEmpty($email)) {
        $errors[] = "Email is required";
    } elseif(!minLen($email, 10)) {
        $errors[] = "Email must be greater than 10 chars";
    } elseif(!maxLen($email, 100)) {
        $errors[] = "Email must be lower than 100 chars";
    } elseif(!validEmail($email)) {
        $errors[] = "Please type a valid email";
    } 

    if(!checkEmpty($password)) {
        $errors[] = "Password is required";
    } elseif(!minLen($password, 5)) {
        $errors[] = "Password must be greater than 5 chars";
    } elseif(!maxLen($password, 100)) {
        $errors[] = "Password must be lower than 100 chars";
    }

    if(!checkEmpty($phone)) {
        $errors[] = "Phone Number is required";
    } elseif(!checkNum($phone)) {
        $errors[] = "Phone Number must be a number";
    } elseif(!minLen($phone, 7)) {
        $errors[] = "Phone Number must be greater than 7 number";
    } elseif(!maxLen($phone, 30)) {
        $errors[] = "Phone Number must be lower than 30 number";
    }

    $file_handle = fileHandling($_FILES['image'], "users");
    if($file_handle[0] == false) {
        $errors[] = $file_handle[1];
    }
    if(empty($errors)) {
        $data = [
            "name"=>$name,
            "email"=>$email,
            "password"=>password_hash($password, PASSWORD_DEFAULT),
            "phone"=>$phone,
            "type"=>$type,
            "img"=>$file_handle[1]
        ];
        $res = insert("users", $data);
        if($res) {
            $_SESSION['db_success'] = "Successfully Added a new User";
            redirect(URL."pages/users/addUser.php");
            die;
        } else {
            $_SESSION['db_error'] = "Failed To Add a new User";
            redirect(URL."pages/users/addUser.php");
            die;
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect(URL."pages/users/addUser.php");
        die;
    }

}

?>