<?php
require_once './src/database/database.php';

class Reserva
{
    private $conn;
    private $table = "reserva";

    public $id;
    public $data;
    public $inicio_reserva;
    public $fim_reserva;
    public $observacao;
    public $espaco_id;
    public $usuario_id;
    public $disciplina_id;

    public $evento_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
        $query = "INSERT INTO " . $this->table . "(data, inicio_reserva, fim_reserva, observacao, espaco_id, usuario_id, disciplina_id, evento_id) VALUES (:data, :inicio_reserva, :fim_reserva, :observacao, :espaco_id, :usuario_id, :disciplina_id, :evento_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':data', $this->data);
        $stmt->bindParam(':inicio_reserva', $this->inicio_reserva);
        $stmt->bindParam(':fim_reserva', $this->fim_reserva);
        $stmt->bindParam(':observacao', $this->observacao);
        $stmt->bindParam(':espaco_id', $this->espaco_id);
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':disciplina_id', $this->disciplina_id);
        $stmt->bindParam(':evento_id', $this->evento_id);

        return $stmt->execute();
    }
}
?>