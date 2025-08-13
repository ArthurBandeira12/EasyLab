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
          <h1>Espaço</h1>
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
      <div class="detalhes-espaco-container">
        <h1>Detalhes do Espaço</h1>

        <?php if ($espaco): ?>
          <ul>
            <li><strong>ID:</strong> <?= $espaco['id'] ?></li>
            <li><strong>Nome:</strong> <?= htmlspecialchars($espaco['nome']) ?></li>
            <li><strong>Capacidade:</strong> <?= $espaco['capacidade'] ?></li>
            <li><strong>Tipo de Espaço:</strong> <?= htmlspecialchars($espaco['tipo_nome']) ?></li>
          </ul>
        <?php else: ?>
          <p>Espaço não encontrado.</p>
        <?php endif; ?>

        <a href="index.php?action=espaco">Voltar à lista</a>
      </div>
    </main>
    <?php include_once './src/components/footer.php'; ?>
  </div>
</body>