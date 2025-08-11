<?php include_once './src/components/head.php'; ?>
<body>
<?php include_once './src/components/header.php'; ?>
<div class="novo-tipoespaco-container">
<h2>Novo Tipo de Espaço</h2>
<form action="index.php?action=create-tipoespaco" method="POST">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>
    <br><br>
    <button type="submit">Salvar</button>
    <a href="index.php?action=tipoespaco">Cancelar</a>
</form>
</div>
