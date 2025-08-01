<?php
include_once 'src/utils/auth.php';
?>

<header>
    <nav class="navbar-container">
        <h1><a href="index.php?action=home">EasyLab</a></h1>
        <div class="navbar-dropdown">
            <div>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <?php if (isAdmin()): ?>
                        <li><a href="index.php?action=create-espaco">Espaços</a></li>
                    <?php endif; ?>
                <div>
                   <!-- <img src="../assets/images/gata.jpg"> -->
                    <div><span></span></div> <!-- nome do usuário -->
                </div>
                <div>
                    <p><?= htmlspecialchars($_SESSION['email']) ?></p> <!-- email do usuário -->
                </div>
            </div>
            <?php endif; ?>
            <ul class="profile-info">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li><a href="index.php?action=logout">Sair</a></li>
                    <li><a href="index.php?action=index-user">Perfil</a></li>

                <?php else: ?>
                    <li><a href="index.php?action=create-usuario">Criar Conta</a></li>
                    <li><a href="index.php?action=login-form">Entrar</a></li>
                <?php endif; ?>
            </ul>
            <!--<ul>
                <li><a href="#">Calendário de Reserva</a></li>
                <li><a href="#">Histórico de Reservas</a></li>
                <li><a href="index.php?action=disponibilidade">Disponibilidade dos Espaços</a></li>
                <li><a href="#">Configurações</a></li>
                <li><a href="#">Sair</a></li>
            </ul>-->
        </div>
    </nav>
</header>