<?php

namespace controller;

use enum\FilePathEnum;
use config\Config;

require_once __DIR__."/../shared/filePathEnum.php";
require_once __DIR__."/../inc/config.inc.php";

interface ProductInterface {
    public function getProducts();
    public function getProduct(string $product_id);
    public function updateCart(array $post): array;
    public function updateCartCosts(array $cart): bool;
    public function deleteFromCart(array $post): array;
}

class ProductController implements ProductInterface {
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function getProducts()
    {
        $req = $this->config->getPdo()->prepare("SELECT * FROM products");
        $res = $req->execute();
        $prodcuts = $req->fetchAll();

        if(!$res || !$prodcuts) {
            return false;
        }

        return $prodcuts;
    }

    public function getProduct(string $product_id)
    {
        if(!$product_id) {
            return false;
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM products WHERE id = :productId");
        $res = $req->execute(array("productId" => $product_id));
        $product = $req->fetch();

        if(!$product) {
            return false;
        }

        return $product;
    }

    public function updateCart(array $post): array
    {
        $name = $post["name"];
        $color = $post["color"];
        $size = $post["size"];
        $price = $post["price"];
        $img_path  = $post["img_path"];
        $quantity = $post["quantity"];
        $product_id  = $post["product_id"];

        if(!isset($_SESSION["cart"]) || empty($_SESSION["cart"])){
            $_SESSION["cart"] = [[
                "name" => $name,
                "color" => $color,
                "size" => $size,
                "price" => $price,
                "img_path" => $img_path,
                "quantity" => $quantity,
                "product_id" => $product_id,
            ]]; 
        } else {
            array_push($_SESSION["cart"], [
                "name" => $name,
                "color" => $color,
                "size" => $size,
                "price" => $price,
                "img_path" => $img_path,
                "quantity" => $quantity,
                "product_id" => $product_id,
            ]);
        }

        return ["state" => true, "message" => "Successfully added to your Cart!", "product_id" => $product_id];
    }

    public function updateCartCosts(array $cart): bool
    {
        $mwst = 19;
        $sub_total = 0;
        $total = 0;
        $taxes = 0;
        
        if(empty($cart)) {
            return false;
        }

        foreach($cart as $product) {
            $sub_total += round($product["price"] * $product["quantity"], 2);
        }
        $taxes = round(($mwst * $sub_total) / 100, 2);
        $total = round($sub_total + $taxes, 2);

        $_SESSION["cart_costs"] = [
            "sub_total" => $sub_total,
            "total" => $total,
            "taxes" => $taxes,
        ];

        return true;
    }

    public function deleteFromCart(array $post): array
    {
        $product_id = $post["product_id"];

        if(!$product_id) {
            return $this->config->response(false, "Product not found!");
        }
        if(!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            return $this->config->response(false, "Cart not found!");
        }

        $check = count($_SESSION["cart"]);
        foreach($_SESSION["cart"] as $index=>$product) {
            if($product["product_id"] === $product_id) {
                array_splice($_SESSION["cart"], $index, 1);
            }
        }

        if($check == count($_SESSION["cart"])) {
            return $this->config->response(false, "Failed to delete Product!");
        }

        if(count($_SESSION["cart"]) == 0) {
            unset($_SESSION["cart_costs"]);
        }

        return $this->config->response(true, "Successfully deleted from Cart!");
    }

}