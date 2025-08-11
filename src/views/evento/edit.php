<?php include_once './src/components/head.php'; ?>
<body>
<?php include_once './src/components/header.php'; ?>

<div class="container">
    <h1>Editar Evento</h1>

    <form action="index.php?action=edit-evento" method="POST" style="max-width: 400px;">
        <input type="hidden" name="id" value="<?= $evento['id'] ?>">

        <label for="nome">Nome do Evento</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($evento['nome']) ?>" required>

        <br><br>
        <button type="submit">Atualizar</button>
    </form>

    <br>
    <a href="index.php?action=evento">Voltar</a>
</div>
</body>
