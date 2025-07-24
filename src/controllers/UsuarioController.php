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

    public function indexRegistrar()
    {
        return [
            'view' => './src/views/auth/registrar.php',
            'data' => []
        ];
    }

    public function indexLogin()
    {
        return [
            'view' => './src/views/auth/login.php',
            'data' => []
        ];
    }

    public function registrar()
    {

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
                    header("Location: index.php?action=login-form");
                    exit;
                } else {
                    $mensagem = "Erro ao registrar usuário.";
                }
            }
        }
        return [
            'view' => './src/views/auth/registrar.php',
            'data' => ['mensagem' => $this->mensagem]
        ];
    }

    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $stmt = $this->db->prepare("SELECT * FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nome'] = $usuario['nome'];
                header('Location: index.php?action=home');
                exit;
            } else {
                return [
                    'view' => './src/views/auth/login.php',
                    'data' => ['mensagem' => 'Email ou senha incorretos.']
                ];
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: index.php?action=welcome');
        exit;
    }


public function deletarUsuario()
{
    

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: index.php?action=login-form');
        exit;
    }

    $this->usuario->id = $_SESSION['usuario_id'];

    if ($this->usuario->delete()) {
        session_destroy();
        header('Location: index.php?action=welcome');
        exit;
    } else {
        return [
            'view' => './src/views/usuario/index-user.php',
            'data' => ['mensagem' => 'Erro ao deletar a conta.']
        ];
    }
}

public function indexUser(): array {
    
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: index.php?action=login-form');
        exit;
    }

    $mensagem = '';

    $db = new Database();
    $pdo = $db->getConnection();
    $usuario = new Usuario($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario->id = $_SESSION['usuario_id'];
        $usuario->nome = $_POST['nome'];
        $usuario->email = $_POST['email'];
        $usuario->senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_BCRYPT) : null;

        if ($usuario->update()) {
            $_SESSION['nome'] = $usuario->nome;
            $_SESSION['email'] = $usuario->email;
            $mensagem = "Dados atualizados com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar os dados.";
        }
    }

    return [
        'view' => './src/views/usuario/index-user.php',
        'data' => [
            'mensagem' => $mensagem,
            'usuario' => [
                'nome' => $_SESSION['nome'],
                'email' => $_SESSION['email']
            ]
        ]
    ];
}


}
