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
                    <h1>Meu Perfil</h1>
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
            <?php if (!empty($mensagem)): ?>
                <p style="color: green;"><?= htmlspecialchars($mensagem) ?></p>
            <?php endif; ?>

            <div class="edit-user">

                <form action="index.php?action=index-user" method="POST">

                    <label>Nome:</label><br>
                    <input type="text" name="nome" value="<?= htmlspecialchars($_SESSION['nome']) ?>" required><br><br>

                    <label>Email:</label><br>
                    <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required><br><br>

                    <label>Nova senha</label><br>
                    <input type="password" name="senha"><br><br>

                    <button type="submit">Salvar alterações</button>
                </form>


                <form action="index.php?action=deletar-usuario" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível.');">
                    <div class="btn-user-delete">
                        <button type="submit">Excluir Conta</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>