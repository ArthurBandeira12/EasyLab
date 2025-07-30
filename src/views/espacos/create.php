<?php
include_once './src/components/head.php';
?>

<body>
    <?php include_once './src/components/header.php'; ?>
    
    <div class="form-container">
      <h1>Criar Espaço</h1>
    
      <form action="" method="POST">
    
        <label for="Nome">Nome</label>
        <input type="Nome" id="Nome" name="Nome" placeholder="" required>
    
        <label for="Capacidade">Capacidade</label>
        <input type="number" id="Capacidade" name="Capacidade" placeholder="" required>
    
        <select name="Tipo">
            <option value="tipo1">Tipo 1</option>
            <option value="tipo2">Tipo 2</option>
        </select>
    
        <button type="submit">Entrar</button>
      </form>
    </div>
</body>