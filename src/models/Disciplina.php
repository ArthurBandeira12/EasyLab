<?php
require_once './src/database/database.php';

class Disciplina
{
    private $conn;
    private $table = "disciplina";

    public $id;
    public $nome;
    public $curso_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
        $query = "INSERT INTO " . $this->table . "(nome, curso_id) VALUES (:nome, :curso_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':curso_id', $this->curso_id);

        return $stmt->execute();
    }
}
