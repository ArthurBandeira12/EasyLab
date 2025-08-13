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
      <div class="editar-espaco-form-container">
        <h1>Editar Espaço</h1>

        <form action="index.php?action=edit-espaco" method="POST">
          <input type="hidden" name="id" value="<?= htmlspecialchars($espaco['id']) ?>">

          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nome"
            value="<?= htmlspecialchars($espaco['nome'] ?? '') ?>" required>

          <label for="capacidade">Capacidade</label>
          <input type="number" id="capacidade" name="capacidade"
            value="<?= htmlspecialchars($espaco['capacidade'] ?? '') ?>" required>

          <label for="tipo_espaco_id">Tipo de Espaço</label>
          <select id="tipo_espaco_id" name="tipo_espaco_id" required>
            <?php foreach ($tipos as $tipo): ?>
              <option value="<?= $tipo['id'] ?>"
                <?= ($tipo['id'] == ($espaco['tipo_espaco_id'] ?? '')) ? 'selected' : '' ?>>
                <?= htmlspecialchars($tipo['nome']) ?>
              </option>
            <?php endforeach; ?>
          </select>

          <button type="submit">Salvar Alterações</button>
        </form>

        <a href="index.php?action=espaco" style="margin-top: 20px; display: inline-block;">
          Voltar para a lista
        </a>
      </div>
    </main>
    <?php include_once './src/components/footer.php'; ?>
  </div>
</body>