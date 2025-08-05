<?php
require_once './src/database/database.php';
require_once './src/models/Curso.php';

class CursoController
{
    private $db;
    private $curso;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->curso = new Curso($this->db);
    }

    public function index()
    {
        $stmt = $this->db->prepare("SELECT * FROM curso");
        $stmt->execute();
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'view' => './src/views/curso/index.php',
            'data' => ['cursos' => $cursos]
        ];
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';

            if ($nome) {
                $this->curso->nome = $nome;

                if ($this->curso->create()) {
                    header('Location: index.php?action=curso');
                    exit;
                } else {
                    echo "<script>alert('Erro ao criar curso');</script>";
                }
            } else {
                echo "<script>alert('Informe o nome do curso');</script>";
            }
        }

        return ['view' => './src/views/curso/create.php', 'data' => []];
    }

    public function delete()
    {
        if (!isset($_POST['id'])) {
            echo "ID do curso não fornecido.";
            return;
        }

        $id = (int)$_POST['id'];
        $stmt = $this->db->prepare("DELETE FROM curso WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header('Location: index.php?action=curso');
        exit;
    }

    public function edit(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM curso WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $curso = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'view' => './src/views/curso/edit.php',
            'data' => ['curso' => $curso]
        ];
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $this->db->prepare("
                UPDATE curso SET nome = :nome WHERE id = :id
            ");
            $stmt->execute([
                'nome' => $_POST['nome'],
                'id' => $_POST['id']
            ]);

            header('Location: index.php?action=curso');
            exit;
        }
    }

    public function read(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM curso WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $curso = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'view' => './src/views/curso/read.php',
            'data' => ['curso' => $curso]
        ];
    }
}