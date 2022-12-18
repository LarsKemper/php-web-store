<?php

namespace controller;

use config\Config;
use DateTime;
use enum\RegexEnum;
use Exception;

require_once __DIR__ . "/../shared/FilePathEnum.php";
require_once __DIR__ . "/../shared/RegexEnum.php";
require_once __DIR__."/../inc/config.inc.php";

interface OrderInterface
{
    public function getOrders(string $user_id);
    public function getOrder(string $order_id);
    public function createOrder(array $post): array;
    public function deleteOrder(string $order_id): array;
}

class OrderController implements OrderInterface
{
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function getOrders(string $user_id)
    {
        if(!$user_id) {
            return false;
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM order_details WHERE user_id = :userId");
        $req->execute(array("userId" => $user_id));
        $orders = $req->fetchAll();

        if(empty($orders)) {
            return false;
        }

        return $orders;
    }

    public function getOrder(string $order_id)
    {
        if(!$order_id) {
            return false;
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM order_details WHERE id = :orderId");
        $res = $req->execute(array("orderId" => $order_id));
        $order = $req->fetch();

        if(!$res) {
            return false;
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM order_items WHERE order_id = :orderId");
        $res = $req->execute(array("orderId" => $order_id));
        $order_item_ids = $req->fetchAll();

        if(!$res) {
            return false;
        }

        $order_items = [];
        foreach ($order_item_ids as $id) {
            $req = $this->config->getPdo()->prepare("SELECT * FROM products WHERE id = :id");
            $res = $req->execute(array("id" => $id["product_id"]));
            $product = $req->fetch();
                
            if(!$res) {
                return false;
            }

            $order_items[] = [
                "id" => $id["id"],
                "img_path" => $product["img_path"],
                "product_name" => $product["name"],
                "quantity" => $id["quantity"],
                "price" => $product["price"],
                "size" => $id["size"],
                "color" => $id["color"],
            ];
        }

        if(empty($order) || empty($order_items)) {
            return false;
        }

        return ["details" => $order, "items" => $order_items];
    }

    public function deleteOrder(string $order_id): array
    {
        if(!$order_id) {
            return $this->config->response(false, "Order not found!");
        }

        $req = $this->config->getPdo()->prepare("DELETE FROM order_details WHERE id = :orderId");
        $res = $req->execute(array("orderId" => $order_id));

        if(!$res) {
            return $this->config->response(false, "Failed to delete Order!");
        }

        $req = $this->config->getPdo()->prepare("DELETE FROM order_items WHERE order_id = :orderId");
        $res = $req->execute(array("orderId" => $order_id));

        if(!$res) {
            return $this->config->response(false, "Failed to delete Order!");
        }

        return $this->config->response(true, "Successfully deleted Order!");
    }

    /**
     * @throws Exception
     */
    public function createOrder(array $post): array
    {
        $user_id = $post["user_id"];
        $cart = $_SESSION["cart"];
        $total = $post["total"];
        $month = $post["month"];
        $year = $post["year"];
        $payment_type = $post["payment_type"];
        $name_on_card = htmlspecialchars(trim($post["name_on_card"]));
        $card_number = htmlspecialchars(trim($post["card_number"]));
        $sec_code = htmlspecialchars(trim($post["sec_code"]));

        if(empty($user_id) || empty($cart) || empty($total)) {
            return $this->config->response(false, "Something gone wrong!");
        }

        if(empty($month) || empty($year) || empty($payment_type) || empty($name_on_card) || empty($card_number) || empty($sec_code)) {
            return $this->config->response(false, "Please fill in all information!");
        }

        if(!preg_match(RegexEnum::FULL_NAME, $name_on_card)) {
            return $this->config->response(false, "Please enter valid information!1");
        }

        if(!preg_match(RegexEnum::CARD_NUMBER, $card_number)) {
            return $this->config->response(false, "Please enter valid information!2");
        }

        if(!preg_match(RegexEnum::SEC_CODE, $sec_code)) {
            return $this->config->response(false, "Please enter valid information!3");
        }

        if(new DateTime($month."/".$year) < new DateTime()) {
            return $this->config->response(false, "Expiration Date must be in the future!");
        }

        $pdo = $this->config->getPdo();
        $req = $pdo->prepare("INSERT INTO order_details (user_id, total, payment_type, name_on_card, card_number, expiry, sec_code) VALUES (:userId, :total, :payment_type, :name_on_card, :card_number, :expiry, :sec_code)");

        $res = $req->execute(
            array(
            "userId" => $user_id,
            "total" => $total,
            "payment_type" => $payment_type,
            "name_on_card" => $name_on_card,
            "card_number" => $card_number,
            "expiry" => $month."/".$year,
            "sec_code" => $sec_code,
            )
        );

        $order_id = $pdo->lastInsertId();

        if(!$res) {
            return $this->config->response(false, "Failed to insert into database!");
        } 

        foreach($cart as $product) {
            $req = $this->config->getPdo()->prepare("INSERT INTO order_items (order_id, product_id, quantity, size, color) VALUES (:orderId, :productId, :quantity, :size, :color)");
            $res = $req->execute(
                array(
                "orderId" => $order_id,
                "productId" => $product["product_id"],
                "quantity" => $product["quantity"],
                "size" => $product["size"],
                "color" => $product["color"],
                )
            );

            if(!$res) {
                return $this->config->response(false, "Failed to insert into database!");
            }
        }

        unset($_SESSION["cart"]);
        unset($_SESSION["cart_costs"]);
        
        return $this->config->response(true, "Successfully placed your Order. Thank you!");
    }
}
