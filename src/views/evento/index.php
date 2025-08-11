<?php include_once './src/components/head.php'; ?>
<body>
<?php include_once './src/components/header.php'; ?>

<div class="container">
    <h1>Lista de Eventos</h1>
    <a href="index.php?action=create-evento" style="display:inline-block; margin-bottom: 15px;">Novo Evento</a>
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left;">ID</th>
                <th style="text-align:left;">Nome</th>
                <th style="text-align:left;">Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($eventos as $evento): ?>
            <tr>
                <td><?= $evento['id'] ?></td>
                <td><?= htmlspecialchars($evento['nome']) ?></td>
                <td>
                    <a href="index.php?action=read-evento&id=<?= $evento['id'] ?>">Ver</a> |
                    <a href="index.php?action=edit-evento-form&id=<?= $evento['id'] ?>">Editar</a> |
                    <form action="index.php?action=delete-evento" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $evento['id'] ?>">
                        <button type="submit" style="background:none; border:none; color:red; cursor:pointer; padding:0; font:inherit;">
                            Excluir
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
