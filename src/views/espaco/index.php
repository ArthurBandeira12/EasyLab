<?php include_once './src/components/head.php'; ?>

<body>
    <?php include_once './src/components/header.php'; ?>

    <div class="list-container">
        <h1>Espaços</h1>
        <a href="index.php?action=create-espaco">+ Novo Espaço</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Capacidade</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($espacos as $espaco): ?>
                    <tr>
                        <td><?= $espaco['id'] ?></td>
                        <td><?= htmlspecialchars($espaco['nome']) ?></td>
                        <td><?= $espaco['capacidade'] ?></td>
                        <td><?= htmlspecialchars($espaco['tipo_nome']) ?></td>
                        <td>
                            <a href="index.php?action=read-espaco&id=<?= $espaco['id'] ?>">Ver</a>
                            <a href="index.php?action=edit-espaco-form&id=<?= $espaco['id'] ?>">Editar</a>
                            <form action="index.php?action=delete-espaco" method="POST" style="display:inline" onsubmit="return confirm('Tem certeza?')">
                                <input type="hidden" name="id" value="<?= $espaco['id'] ?>">
                                <button type="submit" style="background:none; border:none; color:#007BFF; cursor:pointer; padding:0; font:inherit;">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</body>