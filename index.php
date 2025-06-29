<?php
require_once './src/controllers/ReservaController.php';

$reservaController = new ReservaController();

$action = $_GET['action'] ?? '';
$id     = $_GET['id'] ?? 0;

// Roteamento de ações
$result = match ($action) {
    'create-reserva'    => $reservaController->create(),
    'list-reserva'      => $reservaController->index(),
    'read-reserva'      => $reservaController->read(),
    'disponibilidade'   => $reservaController->disponibilidade(),
    'update-reserva'    => $reservaController->update(),
    'edit-reserva'      => $reservaController->edit((int)$id), // Novo: rota para edição em nova aba
    default             => ['view' => './src/views/home.php', 'data' => []]
};

// Resposta JSON para leitura
if (in_array($action, ['read-reserva'])) {
    header('Content-Type: application/json');
    echo json_encode($result['data']);
    exit;
}

$view = $result['view'];
$data = $result['data'];

// Renderização da view
if (!empty($view)) {
    extract($data); // Disponibiliza $espacos, $disciplinas, $eventos, $reservas, $reserva
    include($view);
} else {
    include('./src/views/home.php');
}
