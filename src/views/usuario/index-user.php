<?php
include_once './src/components/head.php';
include_once 'src/utils/auth.php';
include_once 'src/utils/user-avatar.php';
?>

<body>
    <?php include_once './src/components/header.php'; ?>

    <div class="content-area">
        
        <?php if (!empty($mensagem)): ?>
            <p style="color: green; text-align: center; margin-top: 20px;"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>

        <div class="edit-user-card">
            
            <div class="card-header">
                <h2>Configurações de Perfil</h2>
                <div class="tabs">
                    <div class="tab active">Meu Perfil</div>
                    
            </div>

            <div class="card-body">
                
                <?php 
                $fotoPerfilUrl = !empty($_SESSION['foto_perfil']) 
                    ? './src/assets/userimage/' . htmlspecialchars($_SESSION['foto_perfil'])
                    : avatarui($_SESSION['nome'] ?? 'Usuário');
                ?>

                <div class="left-column">
                    <div class="avatar-wrapper">
                        <img src="<?= $fotoPerfilUrl ?>" alt="Avatar" id="preview-avatar">
                    </div>
                    
                    <label for="foto_perfil" class="btn-change-photo">
                        Alterar Foto
                    </label>
                    <p id="arquivo-selecionado" style="color: #00A3FF; font-size: 12px; margin-top: 10px; display: none;">✓ Selecionada</p>
                </div>

                <div class="right-column">
                    <form action="index.php?action=index-user" method="POST" enctype="multipart/form-data">
                        <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" onchange="previewImage(event)" style="display: none;">

                        <div class="form-group">
                            <label>NOME</label>
                            <input type="text" name="nome" value="<?= htmlspecialchars($_SESSION['nome']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>EMAIL</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>SENHA</label>
                            <input type="password" name="senha" placeholder="••••••••••">
                        </div>
                        
                      

                        <button type="submit" class="btn-save">SALVAR</button>
                    </form>

                    <div style="clear: both; padding-top: 20px;">
                        <form action="index.php?action=deletar-usuario" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível.');">
                            <button type="submit" class="btn-delete">Excluir Conta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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


    
            </div>
        </main>
    </div>
</body>