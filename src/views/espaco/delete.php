<?php 
include_once './src/components/head.php'; 
?>

<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="container">
    <h1>Excluir Espaço</h1>

    <?php if ($espaco): ?>
      <p>Tem certeza que deseja excluir o espaço <strong><?= htmlspecialchars($espaco['nome']) ?></strong>?</p>

      <form action="index.php?action=delete-espaco" method="POST">
        <input type="hidden" name="id" value="<?= $espaco['id'] ?>">
        <button type="submit" style="background-color:red; color:white; padding:5px 10px; border:none; cursor:pointer;">
          Sim, excluir
        </button>
        <a href="index.php?action=espaco" style="margin-left: 20px; text-decoration:none; color:#007BFF;">
          Cancelar
        </a>
      </form>

    <?php else: ?>
      <p>Espaço não encontrado.</p>
      <a href="index.php?action=espaco" style="text-decoration:none; color:#007BFF;">
        Voltar
      </a>
    <?php endif; ?>
  </div>
</body>
</html>
