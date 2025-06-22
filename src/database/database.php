<?php

class Database
{

    private $host = '127.0.0.1:3306';
    private $db = 'easylab';
    private $user = 'root';
    private $pass = 'root';
    public $conn = null;

    public function getConnection()
    {

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db};charset=utf8", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Falha na conexão: ' . $e->getMessage();
        }

        return $this->conn;
    }

    
}
