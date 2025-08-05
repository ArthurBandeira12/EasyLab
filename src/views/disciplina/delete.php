<?php 
 include_once './src/components/head.php'; ?>
  <body>
   <?php include_once './src/components/header.php'; ?>

    <div class="container">
    <h1>Excluir Disciplina</h1>

    <?php if ($disciplina): ?>
      <p>Tem certeza que deseja excluir a disciplina <strong><?= htmlspecialchars($disciplina['nome']) ?></strong>?</p>

      <form action="index.php?action=delete-disciplina" method="POST">
        <input type="hidden" name="id" value="<?= $disciplina['id'] ?>">
        <button type="submit" style="background-color:red; color:white;">Sim, excluir</button>
        <a href="index.php?action=disciplina" style="margin-left: 20px;">Cancelar</a>
      </form>
    <?php else: ?>
      <p>Disciplina não encontrada.</p>
      <a href="index.php?action=disciplina">Voltar</a>
    <?php endif; ?>
  </div>
</body>
</html>