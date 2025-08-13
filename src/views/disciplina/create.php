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
          <h1>Disciplinas</h1>
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
        <h1>Nova Disciplina</h1>

        <form action="index.php?action=create-disciplina" method="POST">
          <label for="nome">Nome da Disciplina</label>
          <input type="text" id="nome" name="nome" required>

          <label for="curso_id">Curso</label>
          <select id="curso_id" name="curso_id" required>
            <option value="">Selecione um curso</option>
            <?php foreach ($cursos as $curso): ?>
              <option value="<?= $curso['id'] ?>"><?= htmlspecialchars($curso['nome']) ?></option>
            <?php endforeach; ?>
          </select>

          <button type="submit">Adicionar Disciplina</button>
        </form>

        <a href="index.php?action=disciplina" style="margin-top: 10px; display: inline-block;">Voltar para a lista</a>
      </div>
    </main>
    <?php include_once './src/components/footer.php'; ?>
  </div>
</body>