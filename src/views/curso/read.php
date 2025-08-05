<?php include_once './src/components/head.php'; ?>
<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="container">
    <h1>Detalhes do Curso</h1>

    <?php if ($curso): ?>
      <ul>
        <li><strong>ID:</strong> <?= $curso['id'] ?></li>
        <li><strong>Nome:</strong> <?= htmlspecialchars($curso['nome']) ?></li>
      </ul>
    <?php else: ?>
      <p>Curso não encontrado.</p>
    <?php endif; ?>

    <a href="index.php?action=curso" style="margin-top: 20px; display: inline-block;">← Voltar à lista</a>
  </div>
</body>
</html>