<?php
 include_once './src/components/head.php'; ?>
  
  <body>
   <?php include_once './src/components/header.php'; ?>

    <div class="editar-espaco-form-container">
    <h1>Editar Disciplina</h1>

    <form action="index.php?action=edit-disciplina" method="POST">
      <input type="hidden" name="id" value="<?= $disciplina['id'] ?>">

      <label for="nome">Nome da Disciplina</label>
      <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($disciplina['nome']) ?>" required>

      <label for="curso_id">Curso</label>
      <select id="curso_id" name="curso_id" required>
        <?php foreach ($cursos as $curso): ?>
          <option value="<?= $curso['id'] ?>" <?= $curso['id'] == $disciplina['curso_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($curso['nome']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <button type="submit">Salvar Alterações</button>
    </form>

    <a href="index.php?action=disciplina" style="margin-top: 20px; display: inline-block;">Voltar para a lista</a>
  </div>
</body>