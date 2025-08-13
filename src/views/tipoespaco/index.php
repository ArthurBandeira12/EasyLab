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
                    <h1>Tipo Espaço</h1>
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

            <div class="tipoespaco-container">
                <h1>Tipos de Espaço</h1>
                <a href="index.php?action=create-tipoespaco">Novo Tipo</a>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tipos)): ?>
                            <?php foreach ($tipos as $tipo): ?>
                                <tr>
                                    <td><?= htmlspecialchars($tipo['id']) ?></td>
                                    <td><?= htmlspecialchars($tipo['nome']) ?></td>
                                    <td>
                                        <a href="index.php?action=read-tipoespaco&id=<?= $tipo['id'] ?>">Ver</a>
                                        <a href="index.php?action=edit-tipoespaco&id=<?= $tipo['id'] ?>">Editar</a>
                                        <form action="index.php?action=delete-tipoespaco" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $tipo['id'] ?>">
                                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">Nenhum tipo encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php include_once './src/components/footer.php'; ?>
    </div>
</body>