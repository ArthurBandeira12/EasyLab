<?php
require_once './src/database/database.php';

class Evento
{
    private $conn;
    private $table = "evento";

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
}
?>