<?php include_once './src/components/head.php'; ?>
<body>
  <?php include_once './src/components/header.php'; ?>

  <div class="form-container">
    <h1>Editar Espaço</h1>

    <form action="index.php?action=edit-espaco" method="POST">
      <input type="hidden" name="id" value="<?= $espaco->id ?>">

      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($espaco->nome) ?>" required>

      <label for="capacidade">Capacidade</label>
      <input type="number" id="capacidade" name="capacidade" value="<?= $espaco->capacidade ?>" required>

      <label for="tipo_espaco_id">Tipo de Espaço</label>
      <select id="tipo_espaco_id" name="tipo_espaco_id" required>
        <?php foreach ($tipos as $tipo): ?>
          <option value="<?= $tipo['id'] ?>" <?= $tipo['id'] == $espaco->tipo_espaco_id ? 'selected' : '' ?>>
            <?= htmlspecialchars($tipo['nome']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <button type="submit">Salvar Alterações</button>
    </form>
    <a href="index.php?action=espaco" style="margin-top: 20px; display: inline-block;">Voltar para a lista</a>

  </div>
</body>
