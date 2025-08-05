<?php 
 include_once './src/components/head.php'; ?>
  
  <body>
   <?php include_once './src/components/header.php'; ?>

    <div class="container">
    <h1>Detalhes da Disciplina</h1>

    <?php if ($disciplina): ?>
      <ul>
        <li><strong>ID:</strong> <?= $disciplina['id'] ?></li>
        <li><strong>Nome:</strong> <?= htmlspecialchars($disciplina['nome']) ?></li>
        <li><strong>Curso:</strong> <?= htmlspecialchars($disciplina['curso_nome']) ?></li>
      </ul>
    <?php else: ?>
      <p>Disciplina não encontrada.</p>
    <?php endif; ?>

    <a href="index.php?action=disciplina" style="margin-top: 20px; display: inline-block;">← Voltar à lista</a>
  </div>
</body>
</html>