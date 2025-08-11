<?php include_once './src/components/head.php'; ?>
<body>
<?php include_once './src/components/header.php'; ?>


<h2>Editar Tipo de Espaço</h2>
<form action="index.php?action=update-tipoespaco" method="POST">

    <input type="hidden" name="id" value="<?= htmlspecialchars($tipo['id']) ?>">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($tipo['nome']) ?>" required>
    <br><br>
    <button type="submit">Atualizar</button>
    <a href="index.php?action=tipoespaco">Cancelar</a>
</form>
