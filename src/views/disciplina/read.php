<?php 
 include_once './src/components/head.php'; ?>
  
  <body>
   <?php include_once './src/components/header.php'; ?>

    <div class="detalhes-tipoespaco-container">
    <h1>Detalhes da Disciplina</h1>

    <?php if ($disciplina): ?>
      
        <p><strong>ID:</strong> <?= $disciplina['id'] ?></p>
        <p><strong>Nome:</strong> <?= htmlspecialchars($disciplina['nome']) ?></p>
        <p><strong>Curso:</strong> <?= htmlspecialchars($disciplina['curso_nome']) ?></p>
     
    <?php else: ?>
      <p>Disciplina não encontrada.</p>
    <?php endif; ?>

    <a href="index.php?action=disciplina" style="margin-top: 20px; display: inline-block;">Voltar à lista</a>
  </div>
</body>
</html>