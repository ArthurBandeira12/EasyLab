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



    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM evento");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM evento WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $stmt = $this->conn->prepare("UPDATE evento SET nome = :nome WHERE id = :id");
        return $stmt->execute(['nome' => $this->nome, 'id' => $this->id]);
    }

    public function delete()
    {
        $stmt = $this->conn->prepare("DELETE FROM evento WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }
}


?>