<?php
include_once './src/components/head.php';
include_once 'src/utils/auth.php';
include_once 'src/utils/user-avatar.php';
?>

<body>
    <div id="modalContainer"></div>

    <?php include_once './src/components/header.php'; ?>

    <div class="content-area">
        <header class="navbar">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <div class="navbar-title">
                    <h1>Calendário de Reserva</h1>
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
            <div class="container">
                <section class="calendar-container">
                    <div id='calendar'></div>
                </section>

                <section class="reserva-container">
                    <h2>Reservas do Dia</h2>
                    <div id="lista-reservas"></div>
                <div id="modal-confirmacao">
                    <p id="mensagem-modal">Reserva confirmada com sucesso!</p>
                    <button>Fechar</button>
                </div>

                <div id="modal-pergunta" style="display:none;">
                    <div class="modal-content">
                        <p id="mensagem-pergunta">Tem certeza?</p>
                        <div class="modal-buttons">
                            <button id="btn-confirmar-sim">Sim</button>
                            <button id="btn-confirmar-nao">Não</button>
                        </div>
                    </div>
                </div>
                    <div class="btn-disponibilidade-wrapper">
                        <a href="index.php?action=disponibilidade" class="btn-disponibilidade">Ver Disponibilidade</a>
                    </div>
                </section>
            </div>
        </main>

        <?php include_once './src/components/footer.php'; ?>
    </div>

    <script src="./src/fullcalendar-6.1.17/dist/index.global.min.js"></script>
    <script src="./src/assets/js/calendar.js"></script>
    <div id="modal-editar" style="display:none;">
        <?php include './src/views/reserva/edit.php'; ?>
    </div>
</body>