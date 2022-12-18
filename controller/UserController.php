<?php

namespace controller;

use config\Config;
use enum\FilePathEnum;
use enum\RegexEnum;

require_once __DIR__ . "/../shared/FilePathEnum.php";
require_once __DIR__ . "/../shared/RegexEnum.php";
require_once __DIR__."/AuthController.php";
require_once __DIR__."/../inc/config.inc.php";

interface UserInterface
{
    public function viewSettings(): void;
    public function viewCart(): void;
    public function updateUser(array $post): array;
    public function updateProfile(array $post): array;
    public function getProfile(string $user_id);
}

class UserController implements UserInterface
{
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
        $path = strlen($_SESSION["user_id"]) > 0 ? $this->settingsPath : $this->authController->get_loginPath();
        header("location: $path");
    }

    public function viewCart(): void
    {
        $path = strlen($_SESSION["user_id"]) > 0 ? $this->cartPath : $this->authController->get_loginPath();
        header("location: $path");
    }

    public function updateUser(array $post): array 
    {
        $firstName = htmlspecialchars(trim($post["firstName"]));
        $lastName = htmlspecialchars(trim($post["lastName"]));
        $email = htmlspecialchars(trim($post["email"]));
        $user_id = $post["user_id"];

        if(empty($user_id)) {
            return $this->config->response(false, "User not found!");
        }

        if(empty($firstName) || empty($lastName) || empty($email)) {
            return $this->config->response(false, "Please fill in all required information!");;
        }

        if(!preg_match(RegexEnum::NAME, $firstName) || !preg_match(RegexEnum::NAME, $lastName) || !preg_match(RegexEnum::EMAIL, $email)) {
            return $this->config->response(false, "Please enter valid information!");
        }
        
        $req = $this->config->getPdo()->prepare("SELECT * FROM users WHERE id = :userId");
        $req->execute(array("userId" => $user_id));
        $user = $req->fetch();

        if(!$user) {
            return $this->config->response(false, "User not found!");
        }

        $req = $this->config->getPdo()->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email WHERE id = :userId");
        $req->execute(array("userId" => $user_id, "firstName" => $firstName, "lastName" => $lastName, "email" => $email));

        $user["firstName"] = $firstName;
        $user["lastName"] = $lastName;
        $user["email"] = $email;
        $this->authController->setSession($user);

        return $this->config->response(true, "Successfully updated!");
    }

    public function updateProfile(array $post): array
    {
        $street = htmlspecialchars(trim($post["street"]));
        $city = htmlspecialchars(trim($post["city"]));
        $postcode = htmlspecialchars(trim($post["postcode"]));
        $country = htmlspecialchars(trim($post["country"]));
        $user_id = $post["user_id"];

        if(empty($user_id)) {
            return $this->config->response(false, "User not found!");
        }

        if(empty($street) || empty($city) || empty($postcode) || empty($country)) {
            return $this->config->response(false, "Please fill in all information!");
        }

        if(!preg_match(RegexEnum::STREET, $street) || !preg_match(RegexEnum::CITY, $city) || !preg_match(RegexEnum::POSTCODE, $postcode)) {
            return $this->config->response(false, "Please enter valid information!");
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM profiles WHERE user_id = :userId");
        $req->execute(array("userId" => $user_id));
        $profile = $req->fetch();

        if(!$profile) {
            $req = $this->config->getPdo()->prepare("INSERT INTO profiles (user_id, street, city, postcode, country) VALUES(:userId, :street, :city, :postcode, :country)");
        } else {
            $req = $this->config->getPdo()->prepare("UPDATE profiles SET street = :street, city = :city, postcode = :postcode, country = :country WHERE user_id = :userId");
        }
        $req->execute(array("userId" => $user_id, "street" => $street, "city" => $city, "postcode" => $postcode, "country" => $country));

        $this->authController->setSession(
            false, [
            "street" => $street,
            "city" => $city,
            "postcode" => $postcode,
            "country" => $country,
            "user_id" => $user_id,
            ]
        );

        return $this->config->response(true, "Successfully updated!");
    }

    public function getProfile(string $user_id)
    {
        if(!$user_id) {
            return false;
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM profiles WHERE user_id = :userId");
        $req->execute(array("userId" => $user_id));
        $profile = $req->fetch();

        if(!$profile) {
            return false;
        }

        return $profile;
    }
}
