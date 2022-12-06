<?php require_once "../../core/config.php"; ?>

<?php

function checkEmpty($input) {
    if(empty($input)) {
        return false;
    }
    return true;
}

function minLen($input, $length) {
    if(strlen($input) < $length) {
        return false;
    }
    return true;
}

function checkNum($num ) {
    if(!is_numeric($num)) {
        return false;
    }
    return true;
}

function minNum($num, $min) {
    if($num < $min) {
        return false;
    }
    return true;
}

function maxLen($input, $length) {
    if(strlen($input) > $length) {
        return false;
    }
    return true;
}

function maxNum($num, $max) {
    if($num > $max) {
        return false;
    }
    return true;
}

function validEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

function fileHandling($file, $folder_name) {

    foreach($file as $key=>$value) {
        $$key = inputHandler($value);
    }
    $new_name = "";
    if($name != "") {
        $path = pathinfo($name);
        $original_name = $path['filename'];
        $ext = $path['extension'];

        $allowedExt = ["png", "jpg", "jpeg"];
        if(in_array($ext, $allowedExt)) {
            if($error == 0) {
                if($size < 1000000) {
                    $new_name = uniqid('', true).".".$original_name;
                    
                    $dest_name = ROOT."assets/uploads/$folder_name/".$new_name;
                    move_uploaded_file($tmp_name, $dest_name);
                } else {
                    return [false, "Your File Too Big"];
                }
            }
        } else {
            return [false, "Your File Is Not Supported"];
        }
    }
    return [true, $new_name];
}

?>