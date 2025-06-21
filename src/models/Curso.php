<?php
require_once './src/database/database.php';

class Curso
{
    private $conn;
    private $table = "curso";

    public $id;
    public $nome;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
        $query = "INSERT INTO " . $this->table . "(nome) VALUES (:nome)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nome', $this->nome);

        return $stmt->execute();
    }

    function index()
    {
        $query = "SELECT * FROM" . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function read()
    {
        $query = "SELECT * FROM" . $this->table . "WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            return true;
        }

        return false;
    }
}
