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
            <div class="detalhes-tipoespaco-container">
                <h2>Detalhes do Tipo de Espaço</h2>
                <p><strong>ID:</strong> <?= htmlspecialchars($tipo['id']) ?></p>
                <p><strong>Nome:</strong> <?= htmlspecialchars($tipo['nome']) ?></p>

                <a href="index.php?action=tipoespaco">Voltar</a>
            </div>
        </main>
        <?php include_once './src/components/footer.php'; ?>
    </div>
</body>