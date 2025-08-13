<?php
include_once './src/components/head.php';
include_once 'src/utils/auth.php';
include_once 'src/utils/user-avatar.php';
?>

<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="content-area">
    <header class="navbar">
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <div class="navbar-title">
          <h1>Espaços</h1>
        </div>
        <div class="user-container">
          <div class="user">
            <a href="index.php?action=index-user">
              <img src="<?= avatarui($_SESSION['nome'] ?? 'Usuário') ?>"
                alt="Avatar"
                class="user-avatar">
            </a>
            <div class="user-info">
              <span class="user-name"><?= htmlspecialchars($_SESSION['nome']) ?></span>
              <span class="user-email"><?= htmlspecialchars($_SESSION['email']) ?></span>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </header>

    <main>
      <div class="criar-espaco-form-container">
        <h1>Criar Espaço</h1>

        <form action="index.php?action=create-espaco" method="POST">

          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nome" required>

          <label for="capacidade">Capacidade</label>
          <input type="number" id="capacidade" name="capacidade" required>

          <label for="tipo_espaco_id">Tipo de Espaço</label>
          <select id="tipo_espaco_id" name="tipo_espaco_id" required>
            <option value="">Selecione um tipo</option>
            <?php foreach ($tipos as $tipo): ?>
              <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['nome']) ?></option>
            <?php endforeach; ?>
          </select>

          <button type="submit">Adicionar Espaço</button>
        </form>
        <a href="index.php?action=espaco" style="display:inline-block; margin-top:10px; text-decoration:none; color:#007BFF;">
          Voltar para a lista de Espaços
        </a>
      </div>
    </main>
    <?php include_once './src/components/footer.php'; ?>
  </div>
</body>