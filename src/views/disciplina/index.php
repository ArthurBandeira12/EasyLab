<?php
include_once './src/components/head.php';
include_once 'src/utils/auth.php';
include_once 'src/utils/user-avatar.php';
?>

<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="content-area">
    <header class="navbar">
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <div class="navbar-title">
          <h1>Disciplinas</h1>
        </div>
        <div class="user-container">
          <div class="user">
            <a href="index.php?action=index-user">
              <img src="<?= avatarui($_SESSION['nome'] ?? 'Usuário') ?>"
                alt="Avatar"
                class="user-avatar">
            </a>
            <div class="user-info">
              <span class="user-name"><?= htmlspecialchars($_SESSION['nome']) ?></span>
              <span class="user-email"><?= htmlspecialchars($_SESSION['email']) ?></span>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </header>

    <main>

      <div class="list-container">
        <div class="list-header">
          <h1>Disciplinas</h1>
          <a href="index.php?action=create-disciplina">+ Nova Disciplina</a>
        </div>

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
                    <button type="submit" style="background:none; border:none; color:#b91c1c; cursor:pointer; padding:0; font:inherit;">Excluir</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>
    <?php include_once './src/components/footer.php'; ?>
  </div>
</body>