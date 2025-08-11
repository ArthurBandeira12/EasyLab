<?php include_once './src/components/head.php'; ?>
<body>
<?php include_once './src/components/header.php'; ?>

<div class="list-container">
    <div class="list-header">
        <h1>Lista de Eventos</h1>
        <a href="index.php?action=create-evento">Novo Evento</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($eventos as $evento): ?>
            <tr>
                <td><?= $evento['id'] ?></td>
                <td><?= htmlspecialchars($evento['nome']) ?></td>
                <td>
                    <a href="index.php?action=read-evento&id=<?= $evento['id'] ?>">Ver</a>
                    <a href="index.php?action=edit-evento-form&id=<?= $evento['id'] ?>">Editar</a>
                    <form action="index.php?action=delete-evento" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $evento['id'] ?>">
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>