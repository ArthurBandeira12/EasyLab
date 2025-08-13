<?php if (isset($_SESSION['usuario_id'])): ?>
    <div class="sidebar">
        <aside class="sidebar-info">
            <div class="sidebar-logo">
                <h1><a href="index.php?action=home">EasyLab</a></h1>
            </div>

            <nav class="sidebar-nav">
                <?php if (isAdmin()): ?>
                    <a href="index.php?action=espaco">Espaços</a>
                    <a href="index.php?action=tipoespaco">Tipo Espaço</a>
                    <a href="index.php?action=evento">Eventos</a>
                    <a href="index.php?action=disciplina">Disciplinas</a>
                    <a href="index.php?action=curso">Cursos</a>
                <?php endif; ?>
                <a href="index.php?action=home">Calendário</a>
                <a href="index.php?action=disponibilidade">Disponibilidade</a>
                <a href="index.php?action=index-user">Configurações</a>
                <a href="index.php?action=logout">Sair</a>
            </nav>
        </aside>
    </div>
<?php else: ?>
    <!-- <div class="topbar">
        <nav class="topbar-container">
            <div class="topbar-logo">
                <h1><a href="index.php?action=login-form">EasyLab</a></h1>
            </div>
            <a href="index.php?action=create-usuario">Criar Conta</a>
            <a href="index.php?action=login-form">Entrar</a>
        </nav>
    </div> -->
<?php endif; ?>