<?php
if(session_status() === PHP_SESSION_NONE){
        session_start();
}

use controller\AuthController;
use controller\UserController;
use enum\FilePathEnum;

require_once __DIR__."/../controller/AuthController.php";
require_once __DIR__."/../controller/UserController.php";
require_once __DIR__."/../shared/filePathEnum.php";

$authController = new AuthController();
$userController = new UserController();

// REQUESTS
// @METHOD POST
$functions = [
    "redirect",
    "logout",
    "updateUser",
    "updateProfile"
];

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: ".FilePathEnum::NOT_FOUND);
} else {
    match_call($functions);
}

function match_call($functions): void {
    $exists = false;
    foreach($functions as $function) {
        if(isset($_POST[$function])) {
            $exists = true;
            $function($_POST[$function]);
        }
    }
    if(!$exists) header("location: ".FilePathEnum::NOT_FOUND);
};

//

function redirect(string $path): void {
    header("location: $path");
}

function logout(): void {
    global $authController;
    try {
        $authController->logout();
    } catch(ErrorException $e){

    }
}

function updateUser(): void {
    global $userController;
    try {
        $res = $userController->updateUser($_POST);
    } catch(ErrorException $e) {
        print_r($e);
    }
    header("location: ".FilePathEnum::SETTINGS."/?state=$res[state]&message=$res[message]");
}

function updateProfile(): void {
    global $userController;
    try {
        $res = $userController->updateProfile($_POST);
    } catch(ErrorException $e) {
        print_r($e);
    }
    header("location: ".FilePathEnum::SETTINGS."/?state=$res[state]&message=$res[message]");
}