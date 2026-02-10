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
                    <h1>Usuários</h1>
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
                <h1>Gerenciamento de Usuários</h1>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['nome']) ?></td>
                                    <td>
                                        <a href="index.php?action=read-usuario&id=<?= $user['id'] ?>">Ver</a>
                                        <form action="index.php?action=deletar-usuarioadm" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php include_once './src/components/footer.php'; ?>
    </div>
</body>