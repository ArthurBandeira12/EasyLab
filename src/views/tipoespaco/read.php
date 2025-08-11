<?php include_once './src/components/head.php'; ?>
<body>
<?php include_once './src/components/header.php'; ?>

<h2>Detalhes do Tipo de Espaço</h2>
<p><strong>ID:</strong> <?= htmlspecialchars($tipo['id']) ?></p>
<p><strong>Nome:</strong> <?= htmlspecialchars($tipo['nome']) ?></p>

<a href="index.php?action=tipoespaco">Voltar</a>
