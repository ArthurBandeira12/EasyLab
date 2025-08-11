<?php include_once './src/components/head.php'; ?>
<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="list-container">
    <h1>Criar Curso</h1>
    <a href="index.php?action=create-curso">+ Novo Curso</a>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cursos as $curso): ?>
          <tr>
            <td><?= $curso['id'] ?></td>
            <td><?= htmlspecialchars($curso['nome']) ?></td>
            <td>
              <a href="index.php?action=read-curso&id=<?= $curso['id'] ?>">Ver</a>
              <a href="index.php?action=edit-curso-form&id=<?= $curso['id'] ?>">Editar</a>
              <form action="index.php?action=delete-curso" method="POST" style="display:inline" onsubmit="return confirm('Tem certeza?')">
                <input type="hidden" name="id" value="<?= $curso['id'] ?>">
                <button type="submit" style="background:none; border:none; color:#b91c1c; cursor:pointer; padding:0; font:inherit;">Excluir</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>