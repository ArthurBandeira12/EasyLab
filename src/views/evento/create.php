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
            <div class="novo-evento-container">
                <h2>Criar Evento</h2>
                <form action="index.php?action=create-evento" method="POST">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" required>
                    <button type="submit">Adicionar Evento</button>
                </form>
                <a href="index.php?action=evento">Voltar</a>
            </div>
        </main>
        <?php include_once './src/components/footer.php'; ?>
    </div>
</body>