<?php

namespace controller;

use enum\FilePathEnum;
use enum\RegexEnum;
use config\Config;

require_once __DIR__."/../shared/filePathEnum.php";
require_once __DIR__."/../shared/regexEnum.php";
require_once __DIR__."/../inc/config.inc.php";

interface AuthInterface {
    public function viewLogin(): void;
    public function viewRegister(): void;
    public function logout(): void;
    public function login(array $post): array;
    public function register(array $post): array;
    public function deleteUser(array $post): array;
    public function isLoggedIn(): bool;
    public function setSession(array $user): void;
    public function get_loginPath(): String;
}

class AuthController implements AuthInterface {
    private $loginPath;
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

    public function logout($res = ["state" => true, "message" => "Successfully logged out!"]): void
    {
        session_destroy();
        session_unset();
        header("location: $this->loginPath?state=$res[state]&message=$res[message]");
    }

    public function login(array $post): array
    {
        $email = trim($post["email"]);
        $password = trim($post["password"]);

        if(empty($email) || empty($password)) {
            return $this->config->response(false, "Please fill all information!");
        }
        if(!preg_match(RegexEnum::EMAIL, $email)) {
            return $this->config->response(false, "Please enter a valid email");
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $result = $req->execute(array("email" => $email));
        $user = $req->fetch();

        if($user !== false && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user"] = $user;
            $_SESSION["firstName"] = $user["firstName"];
            header("location: ../../index.php");
        } else {
            return $this->config->response(false, "Email or password invalid!");
        }

        return $this->config->response(true, "Successful login");
    }

    public function register(array $post): array
    {
        $firstName = htmlspecialchars(trim($post["firstName"]));
        $lastName = htmlspecialchars(trim($post["lastName"]));
        $email = htmlspecialchars(trim($post["email"]));
        $password = trim($post["password"]);
        $password2 = trim($post["password2"]);

        if(empty($firstName) || empty($lastName) || empty($email)) {
            return $this->config->response(false, "Please enter all information!");
        }
        if(!preg_match(RegexEnum::NAME, $firstName) || !preg_match(RegexEnum::NAME, $lastName) || !preg_match(RegexEnum::EMAIL, $email)) {
            return $this->config->response(false, "Please enter a valid information!");
        }
        if(strlen($password) === 0 || !preg_match(RegexEnum::PASSWORD, $password)) {
            return $this->config->response(false, "Please enter a valid password! Password must contain: 1 number, 1 uppercase letter, 1 lowercase letter, 1 non-alpha numeric number, min 8 characters.");
        }
        if($password !== $password2){
            return $this->config->response(false, "Password must match!");
        }

        $req = $this->config->getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $result = $req->execute(array("email" => $email));
        $user = $req->fetch();

        if($user !== false) {
            return $this->config->response(false, "User already exists!");
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $req = $this->config->getPdo()->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)");
        $result = $req->execute(array("firstName" => $firstName, "lastName" => $lastName, "email" => $email, "password" => $hash));

        if(!$result) {
            return $this->config->response(false, "Something gone wrong!");
        }
        
        return $this->config->response(true, "Successful registerd. Please login");
    }

    public function deleteUser(array $post): array
    {
        $user_id = $post["user_id"];

        if(!$user_id) {
            return $this->config->response(false, "User not found!");
        }

        $req = $this->config->getPdo()->prepare("DELETE FROM users WHERE id = :userId");
        $res = $req->execute(array("userId" => $user_id));

        if(!$res) {
            return $this->config->response(false, "Failed to delete User!");
        }

        $req = $this->config->getPdo()->prepare("DELETE FROM profiles WHERE user_id = :userId");
        $res = $req->execute(array("userId" => $user_id));

        if(!$res) {
            return $this->config->response(false, "Failed to delete Profile!");
        }

        $this->logout([
            "state" => true,
            "message" => "Sucessfully delete Account!"
        ]);
 
        return $this->config->response(false, "Failed to redirect!");
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

    public function get_loginPath(): String {
        return $this->loginPath;
    }

}