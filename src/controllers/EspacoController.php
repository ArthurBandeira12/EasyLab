<?php
require_once './src/database/database.php';
require_once './src/models/Espaco.php';

class EspacoController
{
    private $db;
    private $espaco;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->espaco = new Espaco($this->db);
    }

    public function index()
    {
        $espacos = $this->espaco->getAll();
        return [
            'view' => './src/views/espaco/index.php',
            'data' => ['espacos' => $espacos]
        ];
    }

    public function create()
    {
        
        $tipos = $this->getTipos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nome = $_POST['nome'] ?? '';
            $capacidade = $_POST['capacidade'] ?? 0;
            $tipo_espaco_id = $_POST['tipo_espaco_id'] ?? 0;

            if ($nome && $capacidade > 0 && $tipo_espaco_id > 0) {
                $this->espaco->nome = $nome;
                $this->espaco->capacidade = $capacidade;
                $this->espaco->tipo_espaco_id = $tipo_espaco_id;

                if ($this->espaco->create()) {
                    header('Location: index.php?action=espaco');
                    exit;
                } else {
                    echo "<script>alert('Erro ao criar espaço');</script>";
                }
            } else {
                echo "<script>alert('Preencha todos os campos corretamente');</script>";
            }
        }

        
        return ['view' => './src/views/espaco/create.php', 'data' => ['tipos' => $tipos]];
    }

    private function getTipos()
    {
        $stmt = $this->db->prepare("SELECT id, nome FROM tipo_espaco");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  public function delete()
{
    if (!isset($_POST['id'])) {
        echo "ID do espaço não fornecido.";
        return;
    }

    $id = (int)$_POST['id'];

    try {
       
        $this->db->beginTransaction();

       
        $stmt = $this->db->prepare('DELETE FROM reserva WHERE espaco_id = :id');
        $stmt->execute(['id' => $id]);

       
        $stmt = $this->db->prepare('DELETE FROM espaco WHERE id = :id');
        $stmt->execute(['id' => $id]);

        
        $this->db->commit();

        header('Location: index.php?action=espaco');
        exit;
    } catch (PDOException $e) {
        $this->db->rollBack();
        echo "Erro ao excluir espaço: " . $e->getMessage();
    }
}


    public function edit(int $id)
{
    $stmt = $this->db->prepare('SELECT * FROM espaco WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $espaco = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$espaco) {
        // Caso não encontre, redireciona para lista
        header('Location: index.php?action=espaco');
        exit;
    }

    // Buscar tipos de espaço
    $tipos = $this->getTipos();

    return [
        'view' => './src/views/espaco/edit.php',
        'data' => [
            'espaco' => $espaco,
            'tipos'  => $tipos
        ]
    ];
}

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $this->db->prepare('UPDATE espaco SET nome = :nome, capacidade = :capacidade, tipo_espaco_id = :tipo WHERE id = :id');
            $stmt->execute([
                'nome' => $_POST['nome'],
                'capacidade' => $_POST['capacidade'],
                'tipo' => $_POST['tipo_espaco_id'],
                'id' => $_POST['id']
            ]);

            header('Location: index.php?action=espaco');
            exit;
        }
    }

    public function read(int $id)
{
    $stmt = $this->db->prepare('SELECT e.*, t.nome as tipo_nome FROM espaco e 
                                 JOIN tipo_espaco t ON e.tipo_espaco_id = t.id 
                                 WHERE e.id = :id');
    $stmt->execute(['id' => $id]);
    $espaco = $stmt->fetch(PDO::FETCH_ASSOC);

    return ['view' => './src/views/espaco/read.php', 'data' => ['espaco' => $espaco]];
}

}
