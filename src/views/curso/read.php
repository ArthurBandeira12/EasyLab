<?php include_once './src/components/head.php'; ?>
<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="detalhes-tipoespaco-container">
    <h1>Detalhes do Curso</h1>

    <?php if ($curso): ?>
      
       <p><strong>ID:</strong> <?= $curso['id'] ?></p>
        <p><strong>Nome:</strong> <?= htmlspecialchars($curso['nome']) ?></p>
      
    <?php else: ?>
      <p>Curso não encontrado.</p>
    <?php endif; ?>

    <a href="index.php?action=curso" style="margin-top: 20px; display: inline-block;">Voltar à lista</a>
  </div>
</body>
</html>