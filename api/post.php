<?php
if (session_status() === PHP_SESSION_NONE){
        session_start();
}

use controller\AuthController;
use controller\OrderController;
use controller\ProductController;
use controller\UserController;
use enum\FilePathEnum;
use enum\PostRoutesEnum;

require_once __DIR__."/../controller/AuthController.php";
require_once __DIR__."/../controller/UserController.php";
require_once __DIR__."/../controller/ProductController.php";
require_once __DIR__."/../controller/OrderController.php";
require_once __DIR__ . "/../shared/FilePathEnum.php";
require_once __DIR__ . "/../shared/PostRoutesEnum.php";

$authController = new AuthController();
$userController = new UserController();
$productController = new ProductController();
$orderController = new OrderController();

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: ".FilePathEnum::NOT_FOUND);
} else {
    match_call();
}

function match_call(): void
{
    $functions = PostRoutesEnum::getRoutes();

    foreach($functions as $function) {
        if(isset($_POST[$function])) {
            try {
                $function($_POST[$function]);
            } catch (PDOException|Exception|ErrorException $e) {
                print_r($e);
            }

            return;
        }
    }

    header("location: ".FilePathEnum::NOT_FOUND);
}

function redirect(string $path): void
{
    header("location: $path");
}

function register(): void
{
    global $authController;
    $res = $authController->register($_POST);
    header("location: ".FilePathEnum::REGISTER."?state=$res[state]&message=$res[message]");
}

function login(): void
{
    global $authController;
    $res = $authController->login($_POST);

    if($res["state"]) {
        header("location: ".FilePathEnum::HOME);
    }

    header("location: ".FilePathEnum::LOGIN."?state=$res[state]&message=$res[message]");
}

function logout(): void
{
    global $authController;
    $authController->logout();
}

function updateUser(): void
{
    global $userController;
    $res = $userController->updateUser($_POST);
    header("location: ".FilePathEnum::SETTINGS."?state=$res[state]&message=$res[message]");
}

function updateProfile(): void
{
    global $userController;
    $res = $userController->updateProfile($_POST);
    header("location: ".FilePathEnum::SETTINGS."?state=$res[state]&message=$res[message]");
}

function updateCart(): void
{
    global $productController;

    $res = $productController->updateCart($_POST);
    $productController->updateCartCosts($_SESSION["cart"]);

    header("location: ".FilePathEnum::PRODUCT."?product_id=$res[product_id]&state=$res[state]&message=$res[message]");
}

function deleteFromCart(): void
{
    global $productController;
    $res = $productController->deleteFromCart($_POST);

    if(isset($_SESSION["cart_consts"])) {
        $productController->updateCartCosts($_SESSION["cart"]);
    }

    header("location: ".FilePathEnum::CART."?state=$res[state]&message=$res[message]");
}

/**
 * @throws Exception
 */
function createOrder(): void
{
    global $orderController;
    $res = $orderController->createOrder($_POST);
    header("location: ".FilePathEnum::CART."?state=$res[state]&message=$res[message]");
}

function deleteUser(): void
{
    global $authController;
    $res = $authController->deleteUser($_POST);

    if (!$res) {
        header("location: ".FilePathEnum::SETTINGS."?state=$res[state]&message=$res[message]");
    } 
}

function deleteOrder(): void
{
    global $orderController;
    $res = $orderController->deleteOrder($_POST["order_id"]);
    header("location: ".FilePathEnum::SETTINGS."?state=$res[state]&message=$res[message]");
}