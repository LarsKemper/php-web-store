<?php
if(session_status() === PHP_SESSION_NONE) {
        session_start();
}

use controller\AuthController;
use controller\OrderController;
use controller\ProductController;
use controller\UserController;
use enum\FilePathEnum;
use enum\GetRoutesEnum;

require_once __DIR__."/../controller/AuthController.php";
require_once __DIR__."/../controller/UserController.php";
require_once __DIR__."/../controller/ProductController.php";
require_once __DIR__."/../controller/OrderController.php";
require_once __DIR__ . "/../shared/FilePathEnum.php";
require_once __DIR__ . "/../shared/GetRoutesEnum.php";

$authController = new AuthController();
$userController = new UserController();
$productController = new ProductController();
$orderController = new OrderController();

function init_data(string $functionRef, $param = false)
{
    $functions = GetRoutesEnum::getRoutes();

    foreach($functions as $function) {
        if($functionRef === $function) {
            $res = null;

            try {
                $res = $function($param);
            } catch (PDOException|Exception|ErrorException $e) {
                print_r($e);
            }

            return $res;
        }
    }

    header("location: ".FilePathEnum::NOT_FOUND);
    return null;
}

function include_with_prop($fileName, $prop)
{
    extract($prop);
    include $fileName;
}

function getProfile(string $user_id)
{
    global $userController;
    return $userController->getProfile($user_id);
}

function getProducts()
{
    global $productController;
    return $productController->getProducts();
}

function getProduct(string $product_id)
{
    global $productController;
    return $productController->getProduct($product_id);
}

function getOrder(string $order_id)
{
    global $orderController;
    return $orderController->getOrder($order_id);
}

function getOrders(string $user_id)
{
    global $orderController;
    return $orderController->getOrders($user_id);
}
