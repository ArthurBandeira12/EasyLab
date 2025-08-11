<?php
include_once './src/components/head.php';
?>
<body>
   <?php include_once './src/components/header.php'; ?>
    <main class="modificar-outer-container">
        <section class="modificar-container">
            <div class="modificar-header">
                <h2>Modificação de Reserva</h2>
            </div>
            
            
            <form class="modificar-form" action="index.php?action=update-reserva" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($reserva->id ?? '') ?>"> <!-- ID da reserva -->
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="data">Data:</label>
                        <input type="date" id="data" name="data" value="<?= htmlspecialchars($reserva->data ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="inicio_reserva">Início:</label>
                        <input type="datetime-local" id="inicio_reserva" name="inicio_reserva" value="<?= htmlspecialchars($reserva->inicio_reserva ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fim_reserva">Fim:</label>
                        <input type="datetime-local" id="fim_reserva" name="fim_reserva" value="<?= htmlspecialchars($reserva->fim_reserva ?? '') ?>" required>
                    </div>
                    <div class="form-group">
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
                    <div class="form-group">
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
                        <div class="form-group">
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
                
                <div class="form-buttons">
                    <button type="submit" class="btn-salvar">Salvar Alterações</button>
                    <a href="index.php?action=home" class="btn-cancelar">Cancelar</a>
                </div>
            </form>
            
            <form action="index.php?action=delete-reserva" method="post" onsubmit="return confirm('Tem Certeza que deseja cancelar esta reserva?');">
                <div class="delete-reserva">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($reserva->id ?? '') ?>">
                    <button type="submit" class="btn-canreserva">Cancelar Reserva</button>
                </div>
            </form>
            
        </section>
    </main>
    
</body>
</html>
