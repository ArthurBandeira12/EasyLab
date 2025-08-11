<?php include_once './src/components/head.php'; ?>
<body>
<?php include_once './src/components/header.php'; ?>

<div class="tipoespaco-container">
    <h1>Tipos de Espaço</h1>
    <a href="index.php?action=create-tipoespaco">Novo Tipo</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tipos)): ?>
                <?php foreach ($tipos as $tipo): ?>
                    <tr>
                        <td><?= htmlspecialchars($tipo['id']) ?></td>
                        <td><?= htmlspecialchars($tipo['nome']) ?></td>
                        <td>
                            <a href="index.php?action=read-tipoespaco&id=<?= $tipo['id'] ?>">Ver</a>
                            <a href="index.php?action=edit-tipoespaco&id=<?= $tipo['id'] ?>">Editar</a>
                            <form action="index.php?action=delete-tipoespaco" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $tipo['id'] ?>">
                                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">Nenhum tipo encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
