<?php
session_start();

require_once './src/controllers/ReservaController.php';
require_once './src/controllers/UsuarioController.php';
require_once './src/utils/auth.php';
require_once './src/controllers/EspacoController.php';
require_once './src/controllers/DisciplinaController.php';
require_once './src/controllers/CursoController.php';

$reservaController = new ReservaController();
$usuarioController = new UsuarioController();
$espacoController = new EspacoController();
$disciplinaController = new DisciplinaController();
$cursoController = new CursoController();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

$rotasPublicas = ['login-form', 'login-usuario', 'registrar-form', 'create-usuario', 'welcome'];

if (!isset($_SESSION['usuario_id']) && !in_array($action, $rotasPublicas)) {
    $result = ['view' => './src/views/welcome.php', 'data' => []];
} else if (isset($_SESSION['usuario_id']) && in_array($action, $rotasPublicas)) {

    header('Location: index.php?action=home');
    exit;
} else {

    $rotasAdmin = [
        'create-espaco'
    ];

    if (in_array($action, $rotasAdmin) && !isAdmin()) {
        echo "Acesso restrito a administradores.";
        exit;
    }

    $result = match ($action) {
        'create-espaco' => $espacoController->create(),
        'espaco' => $espacoController->index(),
        'read-espaco'         => $espacoController->read((int)($_GET['id'] ?? 0)),
        'edit-espaco'         => $espacoController->edit((int)($_GET['id'] ?? 0)),
        'edit-espaco' => $espacoController->update(), 
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
        'delete-espaco' => $espacoController->delete(), 
        'disciplina' => $disciplinaController->index(),
        'create-disciplina' => $disciplinaController->create(),
        'read-disciplina' => $disciplinaController->read((int)($_GET['id'] ?? 0)),
        'edit-disciplina-form' => $disciplinaController->edit((int)($_GET['id'] ?? 0)),
        'edit-disciplina' => $disciplinaController->update(),
        'delete-disciplina' => $disciplinaController->delete(),
        'curso' => $cursoController->index(),
        'create-curso' => $cursoController->create(),
        'read-curso' => $cursoController->read((int)($_GET['id'] ?? 0)),
        'edit-curso-form' => $cursoController->edit((int)($_GET['id'] ?? 0)),
        'edit-curso' => $cursoController->update(),
        'delete-curso' => $cursoController->delete(),

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
