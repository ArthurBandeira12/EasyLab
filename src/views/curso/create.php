<?php include_once './src/components/head.php'; ?>
<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="novo-evento-container">
    <h1>Novo Curso</h1>

    <form action="index.php?action=create-curso" method="POST">
      <label for="nome">Nome do Curso</label>
      <input type="text" id="nome" name="nome" required>

      <button type="submit">Adicionar Curso</button>
    </form>

    <a href="index.php?action=curso" style="margin-top: 10px; display: inline-block;">Voltar para a lista</a>
  </div>
</body>