<?php
require_once './src/database/database.php';
require_once './src/models/Reserva.php';

class ReservaController
{
    private $db;
    private $reserva;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->reserva = new Reserva($this->db);
    }

    public function index()
    {
        $espacos = $this->db->query("SELECT id, nome, capacidade, tipo_espaco_id FROM espaco")->fetchAll(PDO::FETCH_ASSOC);
        $disciplinas = $this->db->query("SELECT id, nome FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);
        $eventos = $this->db->query("SELECT id, nome FROM evento")->fetchAll(PDO::FETCH_ASSOC);

        return [
            'view' => './src/views/reserva/create.php',
            'data' => ['espacos' => $espacos, 'disciplinas' => $disciplinas, 'eventos' => $eventos]
        ];
    }

    public function create()
    {
        $espacos = $this->db->query("SELECT id, nome, capacidade, tipo_espaco_id FROM espaco")->fetchAll(PDO::FETCH_ASSOC);
        $disciplinas = $this->db->query("SELECT id, nome FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);
        $eventos = $this->db->query("SELECT id, nome FROM evento")->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->reserva->usuario_id = 1;
            $this->reserva->data = $_POST['data'];
            $this->reserva->inicio_reserva = $_POST['inicio_reserva'];
            $this->reserva->fim_reserva = $_POST['fim_reserva'];
            $this->reserva->observacao = $_POST['observacao'];
            $this->reserva->espaco_id = $_POST['espaco_id'];
            $this->reserva->disciplina_id = $_POST['disciplina_id'];
            $this->reserva->evento_id = $_POST['evento_id'];

            if ($this->reserva->create()) {
                header("Location: home.php");
            }
        }

        return ['view' => './src/views/home.php', 'data' => []];
    }
}
?>