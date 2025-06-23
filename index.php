<?php
require_once './src/controllers/ReservaController.php';

$reservaController = new ReservaController();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? 0;

$result = match ($action) {
    'create-reserva'      => $reservaController->create(),
    'list-reserva'        => $reservaController->index(),
    'read-reserva'        => $reservaController->read(),
    // adicionei isso apenas para fazer a arota para disponibilidade
    'disponibilidade'     => $reservaController->disponibilidade(),
    default               => ['view' => './src/views/home.php', 'data' => []]
};

if (in_array($action, ['read-reserva'])) {
    header('Content-Type: application/json');
    echo json_encode($result['data']);
    exit;
}

$view = $result['view'];
$data = $result['data'];

if (!empty($view)) {
    extract($data);
    include($view);
} else {
    include('./src/views/home.php');
}
