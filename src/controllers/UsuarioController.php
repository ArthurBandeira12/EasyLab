<?php
require_once './src/database/database.php';
require_once './src/models/Usuario.php';

class UsuarioController
{

    private $db;

    private $usuario;

    public $mensagem = '';

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function index()
    {
        return [
            'view' => './src/views/auth/registrar.php',
            'data' => []
        ];
    }

    public function registrar()
    {
        $mensagem = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (
                isset($_POST['senha'], $_POST['confirmar_senha']) &&
                $_POST['senha'] !== $_POST['confirmar_senha']
            ) {
                $mensagem = "As senhas não coincidem.";
            } else {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

                $db = new Database();
                $pdo = $db->getConnection();

                $stmt = $pdo->prepare("INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)");
                if ($stmt->execute([$nome, $email, $senha])) {
                    header("Location: registrar.php?sucesso=1");
                    exit;
                } else {
                    $mensagem = "Erro ao registrar usuário.";
                }
            }
        }
    }
}
