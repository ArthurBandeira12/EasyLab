<div id="modal" class="modal" style="display:flex;">
    <div class="modal-content">
        <header class="modal-header">
            <h3 class="modal-title">Nova Reserva</h3>
            <button class="btn-close-modal">
                <i class="fa-solid fa-x"></i>
            </button>
        </header>

        <form action="index.php?action=create-reserva" method="POST">
            <label for="data">Data</label>
            <input type="date" id="data" name="data" required>
            <br>
            <label for="inicio_hora">Início</label>
            <input type="time" id="inicio_hora" name="inicio_hora" required>
            <br>
            <label for="fim_hora">Fim</label>
            <input type="time" id="fim_hora" name="fim_hora" required>
            <br>
            <input type="hidden" id="inicio_reserva" name="inicio_reserva">
            <input type="hidden" id="fim_reserva" name="fim_reserva">
            <! aqui foi onde fiz a modificaão para o usuario não enviar o formulario sem preencher os campos !>
                <label for="espaco_id">Espaço</label>
                <select id="espaco_id" name="espaco_id" required>
                    <option value="">Selecione um espaço</option> //fiz uma pequena modific
                    <?php foreach ($espacos as $espaco): ?>
                        <option value="<?= $espaco['id'] ?>"><?= $espaco['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <label for="disciplina_id">Disciplina</label>
                <select id="disciplina_id" name="disciplina_id" required>
                    <option value="">Selecione uma disciplina</option>
                    <?php foreach ($disciplinas as $disciplina): ?>
                        <option value="<?= $disciplina['id'] ?>"><?= $disciplina['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <label for="evento_id">Evento</label>
                <select id="evento_id" name="evento_id" required>
                    <option value="">Selecione um evento</option>
                    <?php foreach ($eventos as $evento): ?>
                        <option value="<?= $evento['id'] ?>"><?= $evento['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
                <br>

                <label for="observacao">Observação</label>
                <input type="text" id="observacao" name="observacao">
                <br>

                <div class="btn-submit">
                    <button type="submit">Adicionar reserva</button>
                </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('#modal form') || document.querySelector('form[action*="create-reserva"]');
        if (form) {
            form.addEventListener('submit', function(e) {
                var data = document.getElementById('data').value;
                var inicio = document.getElementById('inicio_hora').value;
                var fim = document.getElementById('fim_hora').value;
                document.getElementById('inicio_reserva').value = data + 'T' + inicio;
                document.getElementById('fim_reserva').value = data + 'T' + fim;
            });
        }
    });
</script>