<?php

namespace controller;

use enum\FilePathEnum;
use config\Config;

require_once __DIR__."/../shared/filePathEnum.php";
require_once __DIR__."/../inc/config.inc.php";

interface AuthInterface {
    public function viewLogin(): void;
    public function viewRegister(): void;
    public function logout(): void;
    public function login(array $post): array;
    public function register(array $post): array;
    public function isLoggedIn(): bool;
    public function setSession(array $user): void;
}

class AuthController implements AuthInterface {
    public $loginPath;
    private $registerPath;
    private $config;

    public function __construct()
    {
        $this->loginPath = FilePathEnum::LOGIN;    
        $this->registerPath = FilePathEnum::REGISTER;
        $this->config = new Config();
    }

    public function viewLogin(): void
    {
        header("location: $this->loginPath");
    }

    public function viewRegister(): void
    {
        header("location: $this->registerPath");   
    }

    public function logout(): void
    {
        session_destroy();
        session_unset();
        header("location: $this->loginPath");
    }

    public function login(array $post): array
    {
        $res = ["state" => true, "message" => "Successful login"];
        $email = $post["email"];
        $password = $post["password"];

        $req = $this->config->getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $result = $req->execute(array("email" => $email));
        $user = $req->fetch();

        if($user !== false && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user"] = $user;
            $_SESSION["firstName"] = $user["firstName"];
            header("location: ../../index.php");
        } else {
            $res = ["state" => false, "message" => "Email or password are invalid"];
        }

        return $res;
    }

    public function register(array $post): array
    {
        $res = ["state" => true, "message" => "Successful registerd. Please login"];
        $firstName = trim($post["firstName"]);
        $lastName = trim($post["lastName"]);
        $email = trim($post["email"]);
        $password = $post["password"];
        $password2 = $post["password2"];

        if(empty($firstName) || empty($lastName) || empty($email)) {
            $res = ["state" => false, "message" => "Please enter all informations"];
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $res = ["state" => false, "message" => "Please enter a valid email"];
        }
        if(strlen($password) === 0) {
            $res = ["state" => false, "message" => "Please enter a valid password"];
        }
        if($password !== $password2){
            $res = ["state" => false, "message" => "Passwords must match"];
        }

        if($res["state"]){
            $req = $this->config->getPdo()->prepare("SELECT * FROM users WHERE email = :email");
            $result = $req->execute(array("email" => $email));
            $user = $req->fetch();

            if($user !== false) {
                $res = ["state" => false, "message" => "User already exists"];
            }
        }

        if($res["state"]){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $req = $this->config->getPdo()->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)");
            $result = $req->execute(array("firstName" => $firstName, "lastName" => $lastName, "email" => $email, "password" => $hash));

            if(!$result) {
                $res = ["state" => false, "message" => "Something gone wrong"];
            }
        }

        return $res;
    }

    public function isLoggedIn(): bool
    {
        return $_SESSION["user_id"] === null ? false : true;
    }

    public function setSession($user = false, $profile = false): void
    {
        if($user){
            unset($_SESSION["user"]);
            $_SESSION["user"] = $user;
        }
        if($profile) {
            unset($_SESSION["profle"]);
            $_SESSION["profile"] = $profile;
        }
    }

}