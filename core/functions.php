<?php

function redirect($path) {
    header("Location: $path");
}

function checkRequestMethod($method) {
    if($_SERVER['REQUEST_METHOD'] == $method) {
        return true;
    }
    return false;
}

function checkPostValue($value) {
    if(isset($_POST[$value])) {
        return true;
    }
    return false;
}

function checkGetValue($value) {
    if(isset($_GET[$value])) {
        return true;
    }
    return false;
}

function inputHandler($input) {
    return trim(htmlspecialchars(htmlentities($input)));
}

?>