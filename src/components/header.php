<?php
include_once 'src/utils/auth.php';
function avatarui($nome) {
    $iniciais = "";
    $palavras = explode(" ", $nome);
    foreach ($palavras as $palavra) {
        if (!empty($palavra)) {
            $iniciais .= strtoupper(substr($palavra, 0, 1));
        }
    }
    if (strlen($iniciais) > 2) {
        $iniciais = substr($iniciais, 0, 2);
    }
    return "https://ui-avatars.com/api/?name=" . urlencode($iniciais) . "&background=random&color=fff&size=128";

}
?>

<header>
    <nav class="navbar-container">
        <h1><a href="index.php?action=home">EasyLab</a></h1>
        <div class="navbar-dropdown">
            <div>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <?php if (isAdmin()): ?>
                        <li><a href="index.php?action=create-espaco">Espaços</a></li>
                        <li><a href="index.php?action=create-evento">Evento</a></li>
                        <li><a href="index.php?action=disciplina">Disciplinas</a></li>
                        <li><a href="index.php?action=curso">Cursos</a></li>
                    <?php endif; ?>
                <div>
                    <div class="user-info">
                        <a href="index.php?action=index-user">
                        <img src="<?= avatarui($_SESSION['nome'] ?? 'Usuário') ?>" 
                             alt="Avatar" 
                             class="user-avatar">
                        </a>
                        </div>
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