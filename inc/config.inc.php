<?php

namespace config;

use PDO;

class Config {
    protected $db_host;
    protected $db_name;
    protected $db_user;
    protected $db_password;

    public function __construct()
    {
        $this->db_host = "localhost";
        $this->db_name = "web-store";
        $this->db_user = "root";
        $this->db_password = "";
    }

    public function getPdo(): PDO
    {
        return new PDO("mysql:host=$this->db_host;dbname=$this->db_name", $this->db_user, $this->db_password);
    }

    public function response(bool $state, string $message): array {
        return ["state" => $state, "message" => $message];
    }

}