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
                    <h1>Espaços</h1>
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
                    <h1>Espaços</h1>
                    <a href="index.php?action=create-espaco"> Novo Espaço</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Capacidade</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($espacos as $espaco): ?>
                            <tr>
                                <td><?= $espaco['id'] ?></td>
                                <td><?= htmlspecialchars($espaco['nome']) ?></td>
                                <td><?= $espaco['capacidade'] ?></td>
                                <td><?= htmlspecialchars($espaco['tipo_nome']) ?></td>
                                <td>
                                    <a href="index.php?action=read-espaco&id=<?= $espaco['id'] ?>">Ver</a>
                                    <a href="index.php?action=edit-espaco-form&id=<?= $espaco['id'] ?>">Editar</a>
                                    <form action="index.php?action=delete-espaco" method="POST" style="display:inline" onsubmit="return confirm('Tem certeza?')">
                                        <input type="hidden" name="id" value="<?= $espaco['id'] ?>">
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