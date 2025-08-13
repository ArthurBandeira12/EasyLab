<?php
session_start();

require_once './src/controllers/ReservaController.php';
require_once './src/controllers/UsuarioController.php';
require_once './src/utils/auth.php';
require_once './src/controllers/EspacoController.php';
require_once './src/controllers/DisciplinaController.php';
require_once './src/controllers/CursoController.php';
require_once './src/controllers/EventoController.php';
require_once './src/controllers/Tipo_espacoController.php';

$reservaController = new ReservaController();
$usuarioController = new UsuarioController();
$espacoController = new EspacoController();
$disciplinaController = new DisciplinaController();
$cursoController = new CursoController();
$eventoController = new EventoController();
$tipoEspacoController = new TipoEspacoController();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

$rotasPublicas = ['login-form', 'login-usuario', 'registrar-form', 'create-usuario'];

if (!isset($_SESSION['usuario_id']) && !in_array($action, $rotasPublicas)) {
    $result = ['view' => './src/views/auth/login.php', 'data' => []];
} else if (isset($_SESSION['usuario_id']) && in_array($action, $rotasPublicas)) {

    header('Location: index.php?action=home');
    exit;
} else {

    $rotasAdmin = [
        'create-espaco',
        'espaco',
        'read-espaco',
        'edit-espaco-form',
        'edit-espaco',
        'delete-espaco',
        'disciplina',
        'create-disciplina',
        'read-disciplina',
        'edit-disciplina-form',
        'edit-disciplina',
        'delete-disciplina',
        'curso',
        'create-curso',
        'read-curso',
        'edit-curso-form',
        'edit-curso',
        'delete-curso',
        'evento',
        'create-evento',
        'read-evento',
        'edit-evento-form',
        'edit-evento',
        'delete-evento',
        'tipoespaco',
        'create-tipoespaco',
        'read-tipoespaco',
        'edit-tipoespaco',
        'update-tipoespaco',
        'delete-tipoespaco'
    ];

    if (in_array($action, $rotasAdmin) && !isAdmin()) {
        echo "Acesso permitido apenas a administradores.";
        exit;
    }

    $result = match ($action) {
        'create-espaco' => $espacoController->create(),
        'espaco' => $espacoController->index(),
        'read-espaco'         => $espacoController->read((int)($_GET['id'] ?? 0)),
        'edit-espaco-form'    => $espacoController->edit((int)($_GET['id'] ?? 0)),
        'edit-espaco'         => $espacoController->update(),
        'create-reserva'    => $reservaController->create(),
        'list-reserva'      => $reservaController->index(),
        'read-reserva'      => $reservaController->read(),
        'disponibilidade'   => $reservaController->disponibilidade(),
        'confirm-reserva' => $reservaController->confirm((int)($_POST['id'] ?? 0)),
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
        'evento' => $eventoController->index(),
        'create-evento' => $eventoController->create(),
        'read-evento' => $eventoController->read((int)($_GET['id'] ?? 0)),
        'edit-evento-form' => $eventoController->edit((int)($_GET['id'] ?? 0)),
        'edit-evento' => $eventoController->update(),
        'delete-evento' => $eventoController->delete(),
        'tipoespaco'        => $tipoEspacoController->index(),
        'create-tipoespaco' => $tipoEspacoController->create(),
        'read-tipoespaco'   => $tipoEspacoController->read((int)($_GET['id'] ?? 0)),
        'edit-tipoespaco'   => $tipoEspacoController->edit((int)($_GET['id'] ?? 0)),
        'update-tipoespaco' => $tipoEspacoController->update(),
        'delete-tipoespaco' => $tipoEspacoController->delete(),
        default             => ['view' => './src/views/auth/login.php', 'data' => []]
    };
}

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
