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

<link rel="stylesheet" href="/src/assets/css/register.css">

<div class="form-container">
  <h1>Cadastro</h1>

  <?php if (isset($_GET['sucesso'])): ?>
      <p class="mensagem sucesso">Usuário registrado com sucesso!</p>
  <?php elseif (!empty($mensagem)): ?>
      <p class="mensagem erro"><?= htmlspecialchars($mensagem) ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <label for="nome">Nome completo</label>
    <input type="text" id="nome" name="nome" placeholder="exemplo@discente.ifpe.edu.br" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="exemplo@discente.ifpe.edu.br" required>

    <label for="senha">Senha</label>
    <input type="password" id="senha" name="senha" placeholder="Insira sua senha" required>

    <label for="confirmar_senha">Confirmar Senha</label>
    <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Insira sua senha" required>

    <button type="submit">Cadastre-se</button>
  </form>
</div>

<?php
// Exibir o footer apenas se não houver erro de conexão
if (empty($mensagem) || stripos($mensagem, 'Falha na conexão') === false) {
    include_once './src/components/footer.php';
}
?>
