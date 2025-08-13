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
          <h1>Cursos</h1>
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
      <div class="editar-tipoespaco-container">
        <h1>Editar Curso</h1>

        <form action="index.php?action=edit-curso" method="POST">
          <input type="hidden" name="id" value="<?= $curso['id'] ?>">

          <label for="nome">Nome do Curso</label>
          <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($curso['nome']) ?>" required>

          <button type="submit">Salvar Alterações</button>
        </form>

        <a href="index.php?action=curso" style="margin-top: 20px; display: inline-block;">Voltar para a lista</a>
      </div>
    </main>
    <?php include_once './src/components/footer.php'; ?>
  </div>
</body>