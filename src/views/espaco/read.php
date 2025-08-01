<?php include_once './src/components/head.php'; ?>
<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="container">
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
</body>
</html>
        