<?php
require_once './src/database/database.php';

class Espaco
{
    private $conn;
    private $table = "espaco";

    public $id;
    public $nome;
    public $capacidade;
    public $tipo_espaco_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
{
    $sql = "INSERT INTO espaco (nome, capacidade, tipo_espaco_id) VALUES (:nome, :capacidade, :tipo)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':nome', $this->nome);
    $stmt->bindParam(':capacidade', $this->capacidade);
    $stmt->bindParam(':tipo', $this->tipo_espaco_id);

    return $stmt->execute();
}

    function index()
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function read()
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            $this->capacidade = $row['capacidade'];
            $this->tipo_espaco_id = $row['tipo_espaco_id'];
            return true;
        }

        return false;
    }

   public function getAll()
{
    $query = "
        SELECT e.id, e.nome, e.capacidade, e.tipo_espaco_id, t.nome AS tipo_nome
        FROM espaco e
        JOIN tipo_espaco t ON e.tipo_espaco_id = t.id
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function getTipos()
{
    $sql = "SELECT id, nome FROM tipo_espaco";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
