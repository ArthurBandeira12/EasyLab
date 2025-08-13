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
                    <h1>Reserva</h1>
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
        <main class="edit-layout-container">
            <section class="edit-container">
                <header class="modal-header">
                    <h3 class="modal-title">Modificação de Reserva</h3>
                    <button class="btn-close">
                        <a href="index.php?action=home">
                            <i class="fa-solid fa-x"></i>
                        </a>
                    </button>
                </header>
                <form class="modificar-form" action="index.php?action=update-reserva" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($reserva->id ?? '') ?>"> <!-- ID da reserva -->
                    <div class="form-grid">
                        <div class="data">
                            <label for="data">Data:</label>
                            <input type="date" id="data" name="data" value="<?= htmlspecialchars($reserva->data ?? '') ?>" required>
                        </div>
                        <div class="hora-inicio">
                            <label for="inicio_reserva">Início:</label>
                            <input type="datetime-local" id="inicio_reserva" name="inicio_reserva" value="<?= htmlspecialchars($reserva->inicio_reserva ?? '') ?>" required>
                        </div>
                        <div class="hora-fim">
                            <label for="fim_reserva">Fim:</label>
                            <input type="datetime-local" id="fim_reserva" name="fim_reserva" value="<?= htmlspecialchars($reserva->fim_reserva ?? '') ?>" required>
                        </div>
                        <div class="espaco">
                            <label for="espaco_id">Espaço:</label>
                            <select id="espaco_id" name="espaco_id" required>
                                <option value="">Selecione um espaço</option>
                                <?php foreach ($espacos as $espaco): ?>
                                    <option value="<?= $espaco['id'] ?>" <?= ($reserva->espaco_id ?? '') == $espaco['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($espaco['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="disciplina">
                            <label for="disciplina_id">Disciplina:</label>
                            <select id="disciplina_id" name="disciplina_id" required>
                                <option value="">Selecione uma disciplina</option>
                                <?php foreach ($disciplinas as $disciplina): ?>
                                    <option value="<?= $disciplina['id'] ?>" <?= ($reserva->disciplina_id ?? '') == $disciplina['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($disciplina['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="evento">
                            <label for="evento_id">Evento:</label>
                            <select id="evento_id" name="evento_id" required>
                                <option value="">Selecione um evento</option>
                                <?php foreach ($eventos as $evento): ?>
                                    <option value="<?= $evento['id'] ?>" <?= ($reserva->evento_id ?? '') == $evento['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($evento['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label for="observacao">Observação:</label>
                            <textarea id="observacao" name="observacao" rows="3"><?= htmlspecialchars($reserva->observacao ?? '') ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-salvar">Salvar Alterações</button>
                </form>

                <form action="index.php?action=delete-reserva" method="post" onsubmit="return confirm('Tem Certeza que deseja cancelar esta reserva?');">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($reserva->id ?? '') ?>">
                        <button type="submit" class="btn-deletar-reserva">Cancelar Reserva</button>
                </form>
            </section>
        </main>
        <?php include_once './src/components/footer.php'; ?>
    </div>
</body>