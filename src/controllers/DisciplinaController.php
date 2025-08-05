<?php
require_once './src/database/database.php';
require_once './src/models/Disciplina.php';

class DisciplinaController
{
    private $db;
    private $disciplina;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->disciplina = new Disciplina($this->db);
    }

    public function index()
    {
        $stmt = $this->db->prepare("
            SELECT d.*, c.nome AS curso_nome 
            FROM disciplina d 
            JOIN curso c ON d.curso_id = c.id
        ");
        $stmt->execute();
        $disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'view' => './src/views/Disciplina/index.php',
            'data' => ['disciplinas' => $disciplinas]
        ];
    }

    public function create()
    {
        $cursos = $this->getCursos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $curso_id = $_POST['curso_id'] ?? 0;

            if ($nome && $curso_id > 0) {
                $this->disciplina->nome = $nome;
                $this->disciplina->curso_id = $curso_id;

                if ($this->disciplina->create()) {
                    header('Location: index.php?action=disciplina');
                    exit;
                } else {
                    echo "<script>alert('Erro ao criar disciplina');</script>";
                }
            } else {
                echo "<script>alert('Preencha todos os campos corretamente');</script>";
            }
        }

        return ['view' => './src/views/Disciplina/create.php', 'data' => ['cursos' => $cursos]];
    }

    private function getCursos()
    {
        $stmt = $this->db->prepare("SELECT id, nome FROM curso");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete()
    {
        if (!isset($_POST['id'])) {
            echo "ID da disciplina não fornecido.";
            return;
        }

        $id = (int)$_POST['id'];
        $stmt = $this->db->prepare('DELETE FROM disciplina WHERE id = :id');
        $stmt->execute(['id' => $id]);

        header('Location: index.php?action=disciplina');
        exit;
    }

    public function edit(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM disciplina WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

        $cursos = $this->getCursos();

        return [
            'view' => './src/views/Disciplina/edit.php',
            'data' => ['disciplina' => $disciplina, 'cursos' => $cursos]
        ];
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $this->db->prepare("
                UPDATE disciplina 
                SET nome = :nome, curso_id = :curso_id 
                WHERE id = :id
            ");
            $stmt->execute([
                'nome' => $_POST['nome'],
                'curso_id' => $_POST['curso_id'],
                'id' => $_POST['id']
            ]);

            header('Location: index.php?action=disciplina');
            exit;
        }
    }

    public function read(int $id)
    {
        $stmt = $this->db->prepare("
            SELECT d.*, c.nome as curso_nome 
            FROM disciplina d 
            JOIN curso c ON d.curso_id = c.id 
            WHERE d.id = :id
        ");
        $stmt->execute(['id' => $id]);
        $disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'view' => './src/views/Disciplina/read.php',
            'data' => ['disciplina' => $disciplina]
        ];
    }
}