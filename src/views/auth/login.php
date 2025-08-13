<?php
include_once './src/components/head.php';
?>

<body class="auth-page">
  <div class="form-container">
    <div class="form-content">
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

        <button class="form-btn" type="submit">Entrar</button>
      </form>
      <p class="form-link">Não possui uma conta? <a href="index.php?action=create-usuario">Cadastre-se</a></p>
    </div>
  </div>

  <?php
  if (empty($mensagem) || stripos($mensagem, 'Falha na conexão') === false) {
    include_once './src/components/footer.php';
  }
  ?>
</body>