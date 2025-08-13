<?php
include_once './src/components/head.php';
include_once 'src/utils/auth.php';
include_once 'src/utils/user-avatar.php';
?>

<body>
    <?php include_once './src/components/header.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const abrirModalBtn = document.getElementById('abrirModalReserva');
            const modal = document.getElementById('modal');
            const fecharModalBtn = document.querySelector('.btn-close-modal');

            if (modal) {
                modal.style.display = 'none';
            }

            if (abrirModalBtn && modal) {
                abrirModalBtn.addEventListener('click', function() {
                    modal.style.display = 'flex';
                });
            }

            if (fecharModalBtn && modal) {
                fecharModalBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            }

            // Fecha o modal ao clicar fora dele
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>

    <div class="content-area">
        <header class="navbar">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <div class="navbar-title">
                    <h1>Disponibilidade dos Espaços</h1>
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
                <div class="disponibilidade-outer-container">
                    <section class="disponibilidade-container">
                        <div class="disponibilidade-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h2 style="flex:1; text-align:center;">Disponibilidade</h2>
                            <form method="get" style="margin-right: 1em; display: flex; gap: 0.5em;">
                                <input type="hidden" name="action" value="disponibilidade">
                                <input type="date" name="data" value="<?= htmlspecialchars($data_filtro) ?>" onchange="this.form.submit()" style="padding: 0.5em; border-radius: 6px; border: 1px solid #ccc;">
                                <select name="espaco_id" onchange="this.form.submit()" style="padding: 0.5em; border-radius: 6px; border: 1px solid #ccc;">
                                    <option value="">Todos os Espaços</option>
                                    <?php foreach ($espacos as $espaco): ?>
                                        <option value="<?= $espaco['id'] ?>" <?= (isset($_GET['espaco_id']) && $_GET['espaco_id'] == $espaco['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($espaco['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                            <div>
                                <button type="button" class="btn-adicionar" id="abrirModalReserva">Adicionar reserva</button>
                            </div>
                        </div>
                        <table class="disponibilidade-table">
                            <thead>
                                <tr>
                                    <th>Espaço</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Evento</th>
                                    <th>Solicitante</th>
                                    <th>Nome</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservas as $reserva): ?>
                                    <tr>
                                        <td><?= !empty($reserva['espaco']) ? htmlspecialchars($reserva['espaco']) : '-' ?></td>
                                        <td>
                                            <?= !empty($reserva['data']) ? date('d/m/Y', strtotime($reserva['data'])) : '-' ?>
                                        </td>
                                        <td>
                                            <?= !empty($reserva['inicio']) ? date('H:i', strtotime($reserva['inicio'])) : '00:00' ?>
                                            •
                                            <?= !empty($reserva['fim']) ? date('H:i', strtotime($reserva['fim'])) : '00:00' ?>
                                        </td>
                                        <td><?= !empty($reserva['evento']) ? htmlspecialchars($reserva['evento']) : '-' ?></td>
                                        <td><?= !empty($reserva['solicitante']) ? htmlspecialchars($reserva['solicitante']) : '-' ?></td>
                                        <td><?= !empty($reserva['nome']) ? htmlspecialchars($reserva['nome']) : '-' ?></td>
                                        <td>
                                            <?php if ($reserva['status'] === 'Indisponível'): ?>
                                                <span style="color: #e74c3c;">●</span> Indisponível
                                            <?php elseif ($reserva['status'] === 'Pendente'): ?>
                                                <span style="color: #ffff2eff;">●</span> Pendente
                                            <?php else: ?>
                                                <span style="color: #27ae60;">●</span> Disponível
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </main>
        <?php include_once './src/components/footer.php'; ?>
    </div>
    <!-- include necessário para funcionamento sem bugs do modal do formulário de criação de reserva. -->
    <?php include_once './src/views/reserva/create.php'; ?>
</body>