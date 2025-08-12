<?php 
 include_once './src/components/head.php'; ?>
  <body>
   <?php include_once './src/components/header.php'; ?>

    <div class="criar-espaco-form-container">
    <h1>Nova Disciplina</h1>

    <form action="index.php?action=create-disciplina" method="POST">
      <label for="nome">Nome da Disciplina</label>
      <input type="text" id="nome" name="nome" required>

      <label for="curso_id">Curso</label>
      <select id="curso_id" name="curso_id" required>
        <option value="">Selecione um curso</option>
        <?php foreach ($cursos as $curso): ?>
          <option value="<?= $curso['id'] ?>"><?= htmlspecialchars($curso['nome']) ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit">Adicionar Disciplina</button>
    </form>

    <a href="index.php?action=disciplina" style="margin-top: 10px; display: inline-block;">Voltar para a lista</a>
  </div>
</body>
