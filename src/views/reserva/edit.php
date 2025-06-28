<div id="editModal" class="modal" style="display:block;">
    <div class="modal-content">
        <header class="modal-header">
            <h3 class="modal-title">Reserva</h3>
            <button class="btn-close-modal">
                <i class="fa-solid fa-x"></i>
            </button>
        </header>
        <hr>
        <form action="index.php?action=update-reserva" method="POST">
            <label for="data">Data</label>
            <input type="date" id="data" name="data" required>
    
            <label for="inicio_reserva">Início</label>
            <input type="datetime-local" id="inicio_reserva" name="inicio_reserva" required>
    
            <label for="fim_reserva">Fim</label>
            <input type="datetime-local" id="fim_reserva" name="fim_reserva" required>

            <select id="espaco_id" name="espaco_id" required>
                <option value="">Selecione um espaço</option> 
                <?php foreach ($espacos as $espaco): ?>
                    <option value="<?= $espaco['id'] ?>"><?= $espaco['nome'] ?></option>
                <?php endforeach; ?>
            </select>
    
            <select id="disciplina_id" name="disciplina_id" required>
                <option value="">Selecione uma disciplina</option>
                <?php foreach ($disciplinas as $disciplina): ?>
                    <option value="<?= $disciplina['id'] ?>"><?= $disciplina['nome'] ?></option>
                <?php endforeach; ?>
            </select>
    
            <select id="evento_id" name="evento_id" required>
                <option value="">Selecione um evento</option>
                <?php foreach ($eventos as $evento): ?>
                    <option value="<?= $evento['id'] ?>"><?= $evento['nome'] ?></option>
                <?php endforeach; ?>
            </select>
    
            <label for="observacao">Observação</label>
            <input type="text" id="observacao" name="observacao" required>
            
            <div class="btn-submit">
                <button type="submit">Salvar</button>
            </div>
        </form>
    </div>
</div>