<?php require_once "../../core/config.php";?>
<?php require_once ROOT."core/validations.php" ?>
<?php require_once ROOT."core/functions.php" ?>
<?php require_once ROOT."db/select.php" ?>
<?php
$errors = [];

if(checkRequestMethod("POST") && checkPostValue("email")) {

    foreach($_POST as $key=>$value) {
        $$key = inputHandler($value);
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


    if(empty($errors)) {

        $user_data = select("*", "users", "email='$email' AND type != 'client'");
        
        $password_check = password_verify($password, $user_data[0]['password']);

        if(!empty($user_data) && $password_check) {
            if($user_data[0]['type'] == "admin") {
                $_SESSION['auth'] = [$user_data[0]['id'], $user_data[0]['type']];
                $_SESSION['user_info'] = [$user_data[0]['name'], $user_data[0]['img']];
                
                redirect(URL."pages/users/index.php");
            } elseif($user_data[0]['type'] == "user") {
                $_SESSION['auth'] = [$user_data[0]['id'], $user_data[0]['type']];
                $_SESSION['user_info'] = [$user_data[0]['name'], $user_data[0]['img']];
                redirect(URL."pages/clients/index.php");
            }
        } else {
            $_SESSION['db_error'] = "Email or Password is incorrect";
            redirect(URL."index.php");
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect(URL."index.php");
    }
}
?>