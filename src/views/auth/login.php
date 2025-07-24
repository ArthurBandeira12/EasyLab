<?php
  include_once __DIR__ . '/../../components/head.php';
    
?>

<link rel="stylesheet" href="/src/assets/css/register.css">

<div class="form-container">
  <h1>Seja Bem-vindo!</h1>

  <?php if (isset($_GET['sucesso'])): ?>
      <p class="mensagem sucesso">Usuário registrado com sucesso!</p>
  <?php elseif (!empty($mensagem)): ?>
      <p class="mensagem erro"><?= htmlspecialchars($mensagem) ?></p>
  <?php endif; ?>

  <form action="index.php?action=login-usuario" method="POST">

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="exemplo@discente.ifpe.edu.br" required>

    <label for="senha">Senha</label>
    <input type="password" id="senha" name="senha" placeholder="Insira sua senha" required>

    <button type="submit">Entrar</button>
  </form>
  <p>Não possui uma conta? <a href="index.php?action=create-usuario">Cadastre-se</a></p>
</div>
