<?php
require_once './src/database/database.php';

class EventoController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index()
    {
        $stmt = $this->db->prepare("SELECT * FROM evento");
        $stmt->execute();
        $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'view' => './src/views/evento/index.php',
            'data' => ['eventos' => $eventos]
        ];
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';

            if ($nome) {
                $stmt = $this->db->prepare("INSERT INTO evento (nome) VALUES (:nome)");
                $success = $stmt->execute(['nome' => $nome]);

                if ($success) {
                    header('Location: index.php?action=evento');
                    exit;
                } else {
                    echo "<script>alert('Erro ao criar evento');</script>";
                }
            } else {
                echo "<script>alert('Informe o nome do evento');</script>";
            }
        }

        return ['view' => './src/views/evento/create.php', 'data' => []];
    }

    public function delete()
    {
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=evento');
            exit;
        }

        if (!isset($_POST['id']) || empty($_POST['id'])) {
            echo "ID do evento não fornecido.";
            exit;
        }

        $id = (int)$_POST['id'];
        $stmt = $this->db->prepare('DELETE FROM evento WHERE id = :id');
        $stmt->execute(['id' => $id]);

        header('Location: index.php?action=evento');
        exit;
    }

    public function edit(int $id)
    {
        if (!$id) {
            header('Location: index.php?action=evento');
            exit;
        }

        $stmt = $this->db->prepare("SELECT * FROM evento WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$evento) {
            header('Location: index.php?action=evento');
            exit;
        }

        return [
            'view' => './src/views/evento/edit.php',
            'data' => ['evento' => $evento]
        ];
    }

    public function update()
    {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                echo "ID do evento não fornecido.";
                exit;
            }

            $stmt = $this->db->prepare("UPDATE evento SET nome = :nome WHERE id = :id");
            $stmt->execute([
                'nome' => $_POST['nome'],
                'id'   => $_POST['id']
            ]);

            header('Location: index.php?action=evento');
            exit;
        }
    }

    public function read(int $id)
    {
        if (!$id) {
            header('Location: index.php?action=evento');
            exit;
        }

        $stmt = $this->db->prepare("SELECT * FROM evento WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'view' => './src/views/evento/read.php',
            'data' => ['evento' => $evento]
        ];
    }
}
