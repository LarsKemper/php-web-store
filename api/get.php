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
// @METHOD GET
$functions = [
    "getProfile",
    "getProducts",
    "getProduct",
    "getOrders",
    "getOrder",
];

function init_data(string $functionRef, $param = false) {
    $exists = false;
    global $functions;
    foreach($functions as $function) {
        if($functionRef === $function) {
            $exists = true;
            return $function($param);
        }
    }
    if(!$exists) header("location: ".FilePathEnum::NOT_FOUND);
}

function include_with_prop($fileName, $prop) {
    extract($prop);
    include($fileName);
}

//

// @return array OR bool
function getProfile(string $user_id) {
    global $userController;
    try {
        return $userController->getProfile($user_id);
    } catch (ErrorException $e){
        print_r($e);
    }
}

// @retrun array OR bool
function getProducts() {
    global $productController;
    try {
        return $productController->getProducts();
    } catch (ErrorException $e) {
        print_r($e);
    }
}

// @return array OR bool
function getProduct(string $product_id) {
    global $productController;
    try {
        return $productController->getProduct($product_id);
    } catch (ErrorException $e) {
        print_r($e);
    }
}

// @return array OR bool
function getOrder(string $order_id) {
    global $orderController;
    try {
        return $orderController->getOrder($order_id);
    } catch (ErrorException $e) {
        print_r($e);
    }
}

// @return array OR bool
function getOrders(string $user_id) {
    global $orderController;
    try {
        return $orderController->getOrders($user_id);
    } catch (ErrorException $e) {
        print_r($e);
    }
}