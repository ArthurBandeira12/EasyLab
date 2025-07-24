<?php
session_start();

require_once './src/controllers/ReservaController.php';
require_once './src/controllers/UsuarioController.php';

$reservaController = new ReservaController();
$usuarioController = new UsuarioController();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

$rotasPublicas = ['login-form', 'login-usuario', 'registrar-form', 'create-usuario', 'welcome'];

if (!isset($_SESSION['usuario_id']) && !in_array($action, $rotasPublicas)) {
    $result = ['view' => './src/views/welcome.php', 'data' => []];
} else if (isset($_SESSION['usuario_id']) && in_array($action, $rotasPublicas)) {

    header('Location: index.php?action=home');
    exit;
} else {

    $result = match ($action) {
        'create-reserva'    => $reservaController->create(),
        'list-reserva'      => $reservaController->index(),
        'read-reserva'      => $reservaController->read(),
        'disponibilidade'   => $reservaController->disponibilidade(),
        'update-reserva'    => $reservaController->update(),
        'edit-reserva'      => $reservaController->edit((int)($_GET['id'] ?? 0)),
        'delete-reserva'    => $isPost ? $reservaController->delete((int)($_POST['id'] ?? 0)) : null,
        'create-usuario' => $usuarioController->registrar(),
        'registrar-form' => $usuarioController->indexRegistrar(),
        'login-usuario' => $usuarioController->login(),
        'login-form' => $usuarioController->indexLogin(),
        'logout' => $usuarioController->logout(),
        'home' => ['view' => './src/views/home.php', 'data' => []],
        'index-user' => $usuarioController->indexUser(),
        'deletar-usuario' => $usuarioController->deletarUsuario(),
        default             => ['view' => './src/views/welcome.php', 'data' => []]
    };
}


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
    extract($data);
    include($view);
} else {
    include('./src/views/home.php');
}
