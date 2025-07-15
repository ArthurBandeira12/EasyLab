<<<<<<< HEAD
<?php
require_once './src/controllers/ReservaController.php';

$reservaController = new ReservaController();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

$result = match ($action) {
    'create-reserva'    => $reservaController->create(),
    'list-reserva'      => $reservaController->index(),
    'read-reserva'      => $reservaController->read(),
    'disponibilidade'   => $reservaController->disponibilidade(),
    'update-reserva'    => $reservaController->update(),
    'edit-reserva'      => $reservaController->edit((int)($_GET['id'] ?? 0)),
    'delete-reserva'    => $isPost ? $reservaController->delete((int)($_POST['id'] ?? 0)) : null,
    'registrar-usuario' => ['view' => './src/views/usuario/registrar.php', 'data' => []],
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
=======
<?php
require_once './src/controllers/ReservaController.php';

$reservaController = new ReservaController();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

$result = match ($action) {
    'create-reserva'    => $reservaController->create(),
    'list-reserva'      => $reservaController->index(),
    'read-reserva'      => $reservaController->read(),
    'disponibilidade'   => $reservaController->disponibilidade(),
    'update-reserva'    => $reservaController->update(),
    'edit-reserva'      => $reservaController->edit((int)($_GET['id'] ?? 0)),
    'delete-reserva'    => $isPost ? $reservaController->delete((int)($_POST['id'] ?? 0)) : null,
    'registrar-usuario' => ['view' => './src/views/usuario/registrar.php', 'data' => []],
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
>>>>>>> c0afd7e809541e35bf8140b2476cb9235c17334a
