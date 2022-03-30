<?php

namespace controller;

use enum\FilePathEnum;
use config\Config;

require_once __DIR__."/../shared/filePathEnum.php";
require_once __DIR__."/../inc/config.inc.php";

interface ProductInterface {
    public function getProducts();
    public function getProduct(string $product_id);
}

class ProductController implements ProductInterface {
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function getProducts(): array
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

}