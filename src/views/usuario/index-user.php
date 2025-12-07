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
                <?php 
                $fotoPerfilUrl = !empty($_SESSION['foto_perfil']) 
                    ? './src/assets/userimage/' . htmlspecialchars($_SESSION['foto_perfil'])
                    : avatarui($_SESSION['nome'] ?? 'Usuário');
                ?>
                <label for="foto_perfil" style="cursor: pointer;">
                    <img src="<?= $fotoPerfilUrl ?>" alt="Avatar" id="preview-avatar">
                </label>


                <form action="index.php?action=index-user" method="POST" enctype="multipart/form-data">
                    <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" onchange="previewImage(event)" style="display: none;">

                    <p id="arquivo-selecionado" style="color: #0b5742; font-weight: bold; display: none;">✓ Foto selecionada</p>

                    <label>Nome:</label><br>
                    <input type="text" name="nome" value="<?= htmlspecialchars($_SESSION['nome']) ?>" required><br><br>

                    <label>Email:</label><br>
                    <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required><br><br>

                    <label>Nova senha</label><br>
                    <input type="password" name="senha"><br><br>

                    <button type="submit">Salvar alterações</button>
                </form>

                <script>
                function previewImage(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    // Validar tamanho (2MB = 2097152 bytes)
                    const maxSize = 2097152; // 2MB
                    if (file.size > maxSize) {
                        alert('A imagem é muito grande! O tamanho máximo é 2MB.\nTamanho atual: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                        event.target.value = ''; // Limpar seleção
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function() {
                        document.getElementById('preview-avatar').src = reader.result;
                        document.getElementById('arquivo-selecionado').style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                    console.log('Arquivo selecionado:', file.name, '-', (file.size / 1024 / 1024).toFixed(2) + 'MB');
                }
                </script>


                <form action="index.php?action=deletar-usuario" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível.');">
                    <div class="btn-user-delete">
                        <button type="submit">Excluir Conta</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>