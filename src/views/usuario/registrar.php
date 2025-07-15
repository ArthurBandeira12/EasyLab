<?php

include_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../database/database.php';

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
?>

<h1>Registrar Usuário</h1>
<?php if (isset($_GET['sucesso'])): ?>
    <p>Usuário registrado com sucesso!</p>
<?php elseif (!empty($mensagem)): ?>
    <p><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>

    <label for="confirmar_senha">Confirmar Senha:</label>
    <input type="password" id="confirmar_senha" name="confirmar_senha" required>
    
    <button type="submit">Registrar</button>
</form>

 <?php include_once './src/components/footer.php'; ?>