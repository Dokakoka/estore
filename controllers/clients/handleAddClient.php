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
        $errors[] = "Username is required";
    } elseif(!minLen($name, 3)) {
        $errors[] = "Username must be greater than 3 chars";
    } elseif(!maxLen($name, 100)) {
        $errors[] = "Username must be lower than 100 chars";
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

    if(!checkEmpty($phone)) {
        $errors[] = "Phone Number is required";
    } elseif(!checkNum($phone)) {
        $errors[] = "Phone Number must be a number";
    } elseif(!minLen($phone, 7)) {
        $errors[] = "Phone Number must be greater than 7 number";
    } elseif(!maxLen($phone, 30)) {
        $errors[] = "Phone Number must be lower than 30 number";
    }

    if(empty($errors)) {
        $data = [
            "name"=>$name,
            "email"=>$email,
            "password"=>"",
            "phone"=>$phone,
            "type"=>'client',
        ];
        $res = insert("users", $data);
        if($res) {
            $_SESSION['db_success'] = "Successfully Added a new Client";
            redirect(URL."pages/clients/addClient.php");
            die;
        } else {
            $_SESSION['db_error'] = "Failed To Add a new Client";
            redirect(URL."pages/clients/addClient.php");
            die;
        }
    } else {
        $_SESSION['errors'] = $errors;
        redirect(URL."pages/clients/addClient.php");
        die;
    }

}

?>