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
                    <h1>Eventos</h1>
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
                    <h1>Lista de Eventos</h1>
                    <a href="index.php?action=create-evento">Novo Evento</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($eventos as $evento): ?>
                            <tr>
                                <td><?= $evento['id'] ?></td>
                                <td><?= htmlspecialchars($evento['nome']) ?></td>
                                <td>
                                    <a href="index.php?action=read-evento&id=<?= $evento['id'] ?>">Ver</a>
                                    <a href="index.php?action=edit-evento-form&id=<?= $evento['id'] ?>">Editar</a>
                                    <form action="index.php?action=delete-evento" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $evento['id'] ?>">
                                        <button type="submit">Excluir</button>
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