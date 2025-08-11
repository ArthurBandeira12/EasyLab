<?php include_once './src/components/head.php'; ?>
<body>
<?php include_once './src/components/header.php'; ?>

<div class="detalhes-tipoespaco-container">
    <h1>Detalhes do Evento</h1>
    <p><strong>ID:</strong> <?= $evento['id'] ?></p>
    <p><strong>Nome:</strong> <?= htmlspecialchars($evento['nome']) ?></p>
    <a href="index.php?action=evento">Voltar</a>
</div>
</body>
