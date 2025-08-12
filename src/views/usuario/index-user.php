<?php

include_once __DIR__ . '/../../components/head.php';
?>

<body>
    <?php include_once __DIR__ . '/../../components/header.php'; ?>

    <h1>Perfil do Usuário</h1>

    <?php if (!empty($mensagem)): ?>
    <p style="color: green;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <div class="edit-user">
        
        <form action="index.php?action=index-user" method="POST">

            <label>Nome:</label><br>
            <input type="text" name="nome" value="<?= htmlspecialchars($_SESSION['nome']) ?>" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required><br><br>

            <label>Nova senha (deixe em branco para manter a atual):</label><br>
            <input type="password" name="senha"><br><br>

            <button type="submit">Salvar alterações</button>
        </form>

        
        <form action="index.php?action=deletar-usuario" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível.');">
            <div class="btn-user-delete">
                <button type="submit">Excluir Conta</button>
            </div>
        </form>
    </div>
</body>
