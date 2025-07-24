<?php
require_once __DIR__ . '/../database/database.php';


class Usuario
{
    private $conn;
    private $table = "usuario";

    public $id;
    public $nome;
    public $email;
    public $senha;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
        $query = "INSERT INTO " . $this->table . "(nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);

        return $stmt->execute();
    }

    function update()
    {
        $query = "UPDATE " . $this->table . " SET nome = :nome, email = :email";

    if (!empty($this->senha)) {
        $query .= ", senha = :senha";
    }

    $query .= " WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':nome', $this->nome);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':id', $this->id);

    if (!empty($this->senha)) {
        $stmt->bindParam(':senha', $this->senha);
    }

    return $stmt->execute();
    }

    public function delete()
{
    $query = "DELETE FROM " . $this->table . " WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $this->id);

    return $stmt->execute();
}
}
?>