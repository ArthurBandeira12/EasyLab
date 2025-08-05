<?php 
 include_once './src/components/head.php'; ?>

 <body>
  <?php include_once './src/components/header.php'; ?>

  <div class="list-container">
    <h1>Criar Disciplina</h1>
    <a href="index.php?action=create-disciplina">+ Nova Disciplina</a>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Curso</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($disciplinas as $disciplina): ?>
          <tr>
            <td><?= $disciplina['id'] ?></td>
            <td><?= htmlspecialchars($disciplina['nome']) ?></td>
            <td><?= htmlspecialchars($disciplina['curso_nome']) ?></td>
            <td>
              <a href="index.php?action=read-disciplina&id=<?= $disciplina['id'] ?>">Ver</a>
              <a href="index.php?action=edit-disciplina-form&id=<?= $disciplina['id'] ?>">Editar</a>
              <form action="index.php?action=delete-disciplina" method="POST" style="display:inline" onsubmit="return confirm('Tem certeza que deseja excluir esta disciplina?')">
                <input type="hidden" name="id" value="<?= $disciplina['id'] ?>">
                <button type="submit" style="background:none; border:none; color:#007BFF; cursor:pointer; padding:0; font:inherit;">Excluir</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>