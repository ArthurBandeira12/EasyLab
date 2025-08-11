<?php include_once './src/components/head.php'; ?>
<body>
<?php include_once './src/components/header.php'; ?>

<div class="form-container">
    <h1>Criar Evento</h1>
    <form action="index.php?action=create-evento" method="POST">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>
        <button type="submit">Adicionar Evento</button>
    </form>
    <a href="index.php?action=evento">Voltar</a>
</div>
</body>
