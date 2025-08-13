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
            <div class="novo-tipoespaco-container">
                <h2>Criar Tipo de Espaço</h2>
                <form action="index.php?action=create-tipoespaco" method="POST">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <br><br>
                    <button type="submit">Salvar</button>
                    <a href="index.php?action=tipoespaco">Cancelar</a>
                </form>
            </div>
        </main>
        <?php include_once './src/components/footer.php'; ?>
    </div>
</body>