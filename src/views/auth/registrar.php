<?php
    include_once './src/components/head.php';
?>

<link rel="stylesheet" href="/src/assets/css/register.css">

<div class="form-container">
  <h1>Cadastro</h1>

  <?php if (isset($_GET['sucesso'])): ?>
      <p class="mensagem sucesso">Usuário registrado com sucesso!</p>
  <?php elseif (!empty($mensagem)): ?>
      <p class="mensagem erro"><?= htmlspecialchars($mensagem) ?></p>
  <?php endif; ?>

  <form action="index.php?action=create-usuario" method="POST">
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
