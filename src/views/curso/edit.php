<?php include_once './src/components/head.php'; ?>
<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="form-container">
    <h1>Editar Curso</h1>

    <form action="index.php?action=edit-curso" method="POST">
      <input type="hidden" name="id" value="<?= $curso['id'] ?>">

      <label for="nome">Nome do Curso</label>
      <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($curso['nome']) ?>" required>

      <button type="submit">Salvar Alterações</button>
    </form>

    <a href="index.php?action=curso" style="margin-top: 20px; display: inline-block;">← Voltar para a lista</a>
  </div>
</body>