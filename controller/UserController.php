<?php

namespace controller;

use enum\FilePathEnum;
use controller\AuthController;
use config\Config;

require_once __DIR__."/../shared/filePathEnum.php";
require_once __DIR__."/AuthController.php";
require_once __DIR__."/../inc/config.inc.php";

interface UserInterface {
    public function viewSettings(): void;
    public function viewCart(): void;
    public function updateUser(array $post): array;
    public function updateProfile(array $post): array;
    public function getProfile(string $user_id); // @return array OR bool
}

class UserController implements UserInterface {
    private $authController;
    private $settingsPath;
    private $cartPath;
    private $config;

    public function __construct()
    {
        $this->authController = new AuthController();
        $this->settingsPath = FilePathEnum::SETTINGS;
        $this->cartPath = FilePathEnum::CART;
        $this->config = new Config();
    }

    public function viewSettings(): void
    {   
        $path = strlen($_SESSION["user_id"]) > 0 ? $this->settingsPath : $this->authController->loginPath;
        header("location: $path");
    }

    public function viewCart(): void
    {
        $path = strlen($_SESSION["user_id"]) > 0 ? $this->cartPath : $this->authController->loginPath;
        header("location: $path");
    }

    public function updateUser(array $post): array 
    {
        $firstName = trim($post["firstName"]);
        $lastName = trim($post["lastName"]);
        $email = trim($post["email"]);
        $user_id = $post["user_id"];

        if(empty($user_id)) {
            return $this->config->response(false, "User not found!");
        }
        if(empty($firstName) || empty($lastName) || empty($email)) {
            return $this->config->response(false, "Please fill in all required information!");;
        }
        
        $req = $this->config->getPdo()->prepare("SELECT * FROM users WHERE id = :userId");
        $res = $req->execute(array("userId" => $user_id));
        $user = $req->fetch();

        if(!$user) {
            $this->config->response(false, "User not found!");;
        }

        $req = $this->config->getPdo()->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email WHERE id = :userId");
        $res = $req->execute(array("userId" => $user_id, "firstName" => $firstName, "lastName" => $lastName, "email" => $email));

        $user["firstName"] = $firstName;
        $user["lastName"] = $lastName;
        $user["email"] = $email;
        $this->authController->setSession($user);

        return ["state" => true, "message" => "Successfully updated!"];
    }

    public function updateProfile(array $post): array
    {
        $street = trim($post["street"]);
        $city = trim($post["city"]);
        $postcode = trim($post["postcode"]);
        $country = trim($post["country"]);
        $user_id = $post["user_id"];

        if(empty($user_id)){
            $this->config->response(false, "User not found!");;
        }
        if(empty($street) || empty($city) || empty($postcode) || empty($country)){
            $this->config->response(false, "Please fill in all information!");;
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM profiles WHERE user_id = :userId");
        $res = $req->execute(array("userId" => $user_id));
        $profile = $req->fetch();

        if(!$profile) {
            $req = $this->config->getPdo()->prepare("INSERT INTO profiles (user_id, street, city, postcode, country) VALUES(:userId, :street, :city, :postcode, :country)");
            $res = $req->execute(array("userId" => $user_id, "street" => $street, "city" => $city, "postcode" => $postcode, "country" => $country));
        } else {
            $req = $this->config->getPdo()->prepare("UPDATE profiles SET street = :street, city = :city, postcode = :postcode, country = :country WHERE user_id = :userId");
            $res = $req->execute(array("userId" => $user_id, "street" => $street, "city" => $city, "postcode" => $postcode, "country" => $country));
        }

        $this->authController->setSession(false, [
            "street" => $street,
            "city" => $city,
            "postcode" => $postcode,
            "country" => $country,
            "user_id" => $user_id,
        ]);

        return ["state" => true, "message" => "Successfully updated!"];
    }

    public function getProfile(string $user_id)
    {
        if(!$user_id) {
            return false;
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM profiles WHERE user_id = :userId");
        $res = $req->execute(array("userId" => $user_id));
        $profile = $req->fetch();

        if(!$profile) {
            return false;
        }

        return $profile;
    }
    
}