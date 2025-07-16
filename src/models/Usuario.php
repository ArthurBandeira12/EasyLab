<?php
require_once './src/database/database.php';

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
}
?>