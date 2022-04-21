<?php
if(session_status() === PHP_SESSION_NONE){
        session_start();
}

use controller\AuthController;
use controller\UserController;
use controller\ProductController;
use controller\OrderController;
use enum\FilePathEnum;

require_once __DIR__."/../controller/AuthController.php";
require_once __DIR__."/../controller/UserController.php";
require_once __DIR__."/../controller/ProductController.php";
require_once __DIR__."/../controller/OrderController.php";
require_once __DIR__."/../shared/filePathEnum.php";

$authController = new AuthController();
$userController = new UserController();
$productController = new ProductController();
$orderController = new OrderController();

// REQUESTS
// @METHOD POST
$functions = [
    "redirect",
    "login",
    "register",
    "logout",
    "updateUser",
    "updateProfile",
    "updateCart",
    "deleteFromCart",
    "createOrder",
    "deleteUser",
    "deleteOrder"
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

function register(): void {
    global $authController;
    try {
        $res = $authController->register($_POST);
    } catch(ErrorException $e) {
        print_r($e);
    }
    header("location: ".FilePathEnum::REGISTER."?state=$res[state]&message=$res[message]");
}

function login(): void {
    global $authController;
    try {
        $res = $authController->login($_POST);
    } catch(ErrorException $e) {
        print_r($e);
    }
    if($res["state"]) {
        header("location: ".FilePathEnum::HOME);
    } else {
        header("location: ".FilePathEnum::LOGIN."?state=$res[state]&message=$res[message]");
    }
}

function logout(): void {
    global $authController;
    try {
        $authController->logout();
    } catch(ErrorException $e){
        print_r($e);
    }
}

function updateUser(): void {
    global $userController;
    try {
        $res = $userController->updateUser($_POST);
    } catch(ErrorException $e) {
        print_r($e);
    }
    header("location: ".FilePathEnum::SETTINGS."?state=$res[state]&message=$res[message]");
}

function updateProfile(): void {
    global $userController;
    try {
        $res = $userController->updateProfile($_POST);
    } catch(ErrorException $e) {
        print_r($e);
    }
    header("location: ".FilePathEnum::SETTINGS."?state=$res[state]&message=$res[message]");
}

function updateCart(): void {
    global $productController;
    try {
        $res = $productController->updateCart($_POST);
        $productController->updateCartCosts($_SESSION["cart"]);
    } catch(ErrorException $e) {
        print_r($e);
    }
    header("location: ".FilePathEnum::PRODUCT."?product_id=$res[product_id]&state=$res[state]&message=$res[message]");
}

function deleteFromCart(): void {
    global $productController;
    try {
        $res = $productController->deleteFromCart($_POST);
        if(isset($_SESSION["cart_consts"])) $productController->updateCartCosts($_SESSION["cart"]);
    } catch(ErrorException $e) {
        print_r($e);
    }
    header("location: ".FilePathEnum::CART."?state=$res[state]&message=$res[message]");
}

function createOrder(): void {
    global $orderController;
    try {
        $res = $orderController->createOrder($_POST);
    } catch(ErrorException $e) {
        print_r($e);
    }
    header("location: ".FilePathEnum::CART."?state=$res[state]&message=$res[message]");
}

function deleteUser(): void {
    global $authController;
    try {
        $res = $authController->deleteUser($_POST);
    } catch (ErrorException $e) {
        print_r($e);
    }
    if(!$res) {
        header("location: ".FilePathEnum::SETTINGS."?state=$res[state]&message=$res[message]");
    } 
}

function deleteOrder(): void {
    global $orderController;
    try {
        $res = $orderController->deleteOrder($_POST["order_id"]);
    } catch (ErrorException $e) {
        print_r($e);
    }
    header("location: ".FilePathEnum::SETTINGS."?state=$res[state]&message=$res[message]");
}