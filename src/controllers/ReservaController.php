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

    public function read()
    {
        $sql = "SELECT r.*, 
                       e.nome as evento_nome,
                       esp.nome as espaco_nome,
                       u.nome as nome_usuario
                FROM reserva r 
                INNER JOIN evento e ON r.evento_id = e.id
                INNER JOIN espaco esp ON r.espaco_id = esp.id
                LEFT JOIN usuario u ON r.usuario_id = u.id";
        
        if (!isAdmin()) {
            $sql .= " WHERE r.usuario_id = :usuario_id";
        }
        
        $stmt = $this->db->prepare($sql);
        
        // Executar com parâmetro se não for admin
        if (!isAdmin()) {
            $stmt->execute(['usuario_id' => $_SESSION['usuario_id']]);
        } else {
            $stmt->execute();
        }
        
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'view' => '',
            'data' => ['reservas' => $reservas]
        ];
    }

    public function create()
    {
        $espacos = $this->db->query("SELECT id, nome, capacidade, tipo_espaco_id FROM espaco")->fetchAll(PDO::FETCH_ASSOC);
        $disciplinas = $this->db->query("SELECT id, nome FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);
        $eventos = $this->db->query("SELECT id, nome FROM evento")->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if (
                empty($_POST['data']) ||
                empty($_POST['inicio_reserva']) ||
                empty($_POST['fim_reserva']) ||
                empty($_POST['espaco_id']) ||
                empty($_POST['disciplina_id']) ||
                empty($_POST['evento_id'])
            ) {
                echo "<script>alert('Preencha todos os campos obrigatórios!'); window.history.back();</script>";
                exit;
            }
            $data_reserva = new DateTime($_POST['data']);
            $data_hoje = new DateTime('today');
            $espaco_id = $_POST['espaco_id'];
            $inicio_reserva = $_POST['inicio_reserva'];
            $fim_reserva = $_POST['fim_reserva'];

            // verificação dos parametros da reserva
            $inicio_horario = date('H:i', strtotime($inicio_reserva));
            $fim_horario    = date('H:i', strtotime($fim_reserva));
            $inicio_data = date('Y-m-d', strtotime($inicio_reserva));
            $fim_data    = date('Y-m-d', strtotime($fim_reserva));

            if ($inicio_horario < '07:00' || $fim_horario > '17:50') {
                echo "<script>alert('Horário fora do permitido (07:00 - 17:50)'); window.history.back();</script>";
                exit;
            }
            elseif ($inicio_horario >= $fim_horario) {
                echo "<script>alert('Horário de início deve ser anterior ao horário de fim!'); window.history.back();</script>";
                exit;
            }
            elseif ($inicio_data != $fim_data) {
                echo "<script>alert('Data de início deve ser igual à data de fim!'); window.history.back();</script>";
                exit;
            }
            elseif ($data_reserva < $data_hoje) {
                echo "<script>alert('Não é permitido criar reservas para datas passadas!'); window.history.back();</script>";
                exit;
            }
        

            $stmt = $this->db->prepare(
                "SELECT * FROM reserva 
                 WHERE espaco_id = :espaco_id
                 AND inicio_reserva < :fim_reserva 
                 AND fim_reserva > :inicio_reserva"
            );

            $stmt->execute([
                "espaco_id"       => $espaco_id,
                "inicio_reserva"  => $inicio_reserva,
                "fim_reserva"     => $fim_reserva,
            ]);

            if ($stmt->fetch()) {
                echo "<script>alert('Já existe uma reserva para este espaço nesse horário!'); window.history.back();</script>";
                exit;
            }

            $this->reserva->usuario_id      = $_SESSION['usuario_id'];
            $this->reserva->data            = $_POST['data'];
            $this->reserva->inicio_reserva  = $inicio_reserva;
            $this->reserva->fim_reserva     = $fim_reserva;
            $this->reserva->observacao      = $_POST['observacao'];
            $this->reserva->espaco_id       = $espaco_id;
            $this->reserva->disciplina_id   = $_POST['disciplina_id'];
            $this->reserva->evento_id       = $_POST['evento_id'];

            if ($this->reserva->create()) {
                header("Location: index.php?action=home");
            }
        }

        return ['view' => './src/views/home.php', 'data' => []];
    }

    // área para verificar a disponibilidade dos espaços
    public function disponibilidade()
    {
        $inicio_dia    = '07:00';
        $fim_dia       = '17:50';
        $data_filtro   = $_GET['data'] ?? date('Y-m-d');
        $espaco_filtro = $_GET['espaco_id'] ?? '';

        $espacos     = $this->db->query("SELECT id, nome FROM espaco")->fetchAll(PDO::FETCH_ASSOC);
        $disciplinas = $this->db->query("SELECT id, nome FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);
        $eventos     = $this->db->query("SELECT id, nome FROM evento")->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT r.*, e.nome AS espaco_nome, u.nome AS usuario_nome, ev.nome AS evento_nome
                FROM reserva r
                INNER JOIN espaco e ON r.espaco_id = e.id
                LEFT JOIN usuario u ON r.usuario_id = u.id
                LEFT JOIN evento ev ON r.evento_id = ev.id
                WHERE r.data = :data";
        $params = ['data' => $data_filtro];

        if ($espaco_filtro) {
            $sql .= " AND r.espaco_id = :espaco_id";
            $params['espaco_id'] = $espaco_filtro;
        }
        $sql .= " ORDER BY r.inicio_reserva";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = [];
        foreach ($reservas as $reserva) {
            $map[$reserva['espaco_id']][] = $reserva;
        }

        $resultados = [];
        foreach ($espacos as $espaco) {
            if ($espaco_filtro && $espaco['id'] != $espaco_filtro) continue;

            $reservas_espaco = $map[$espaco['id']] ?? [];
            if (empty($reservas_espaco)) {
                $resultados[] = [
                    'espaco'      => $espaco['nome'],
                    'data'        => $data_filtro,
                    'inicio'      => $inicio_dia,
                    'fim'         => $fim_dia,
                    'evento'      => '-',
                    'solicitante' => '-',
                    'nome'        => '-',
                    'status'      => 'Disponível'
                ];
                continue;
            }

            usort($reservas_espaco, function($a, $b) {
                return strcmp($a['inicio_reserva'], $b['inicio_reserva']);
            });

            $last_end = $inicio_dia;
            foreach ($reservas_espaco as $reserva) {
                $inicio_reserva = date('H:i', strtotime($reserva['inicio_reserva']));
                $fim_reserva    = date('H:i', strtotime($reserva['fim_reserva']));

                if ($inicio_reserva > $last_end) {
                    $resultados[] = [
                        'espaco'      => $espaco['nome'],
                        'data'        => $data_filtro,
                        'inicio'      => $last_end,
                        'fim'         => date('H:i', strtotime($inicio_reserva . ':00') - 60),
                        'evento'      => '-',
                        'solicitante' => '-',
                        'nome'        => '-',
                        'status'      => 'Disponível'
                    ];
                }

                $resultados[] = [
                    'espaco'      => $espaco['nome'],
                    'data'        => $data_filtro,
                    'inicio'      => $inicio_reserva,
                    'fim'         => $fim_reserva,
                    'evento'      => $reserva['evento_nome'],
                    'solicitante' => 'Professor',
                    'nome'        => $reserva['usuario_nome'],
                    'status'      => $reserva['status'] 
                ];
                $last_end = $fim_reserva;
            }

            if ($last_end < $fim_dia) {
                $resultados[] = [
                    'espaco'      => $espaco['nome'],
                    'data'        => $data_filtro,
                    'inicio'      => $last_end,
                    'fim'         => $fim_dia,
                    'evento'      => '-',
                    'solicitante' => '-',
                    'nome'        => '-',
                    'status'      => 'Disponível'
                ];
            }
        }

        return [
            'view' => './src/views/espaco/disponibilidade.php',
            'data' => ['reservas' => $resultados, 'data_filtro' => $data_filtro, 'espacos' => $espacos, 'disciplinas' => $disciplinas, 'eventos' => $eventos]
        ];
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método inválido']);
            exit;
        }

        $id              = $_POST['id'] ?? null;
        $inicio_reserva  = $_POST['inicio_reserva'] ?? null;
        $fim_reserva     = $_POST['fim_reserva'] ?? null;
        $espaco_id       = $_POST['espaco_id'] ?? null;
        $evento_id       = $_POST['evento_id'] ?? null;
        $observacao      = $_POST['observacao'] ?? null;

        if (!$id || !$inicio_reserva || !$fim_reserva || !$espaco_id || !$evento_id) {
            echo json_encode(['success' => false, 'message' => 'Campos obrigatórios faltando']);
            exit;
        }

        // Verificar conflito de horário, ignorando o próprio ID
        $sql = "SELECT * FROM reserva
                WHERE espaco_id = :espaco_id
                  AND id != :id
                  AND inicio_reserva < :fim_reserva
                  AND fim_reserva > :inicio_reserva";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['espaco_id' => $espaco_id, 'id' => $id, 'inicio_reserva' => $inicio_reserva, 'fim_reserva' => $fim_reserva]);

        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Conflito de horário com outra reserva']);
            exit;
        }

        // Atualizar a reserva
        $sqlUpdate = "UPDATE reserva SET
            inicio_reserva = :inicio_reserva,
            fim_reserva    = :fim_reserva,
            espaco_id      = :espaco_id,
            evento_id      = :evento_id,
            observacao     = :observacao
            WHERE id      = :id";
        $stmtUpdate = $this->db->prepare($sqlUpdate);
        $success    = $stmtUpdate->execute(['inicio_reserva' => $inicio_reserva, 'fim_reserva' => $fim_reserva, 'espaco_id' => $espaco_id, 'evento_id' => $evento_id, 'observacao' => $observacao, 'id' => $id]);

        // Detecta se a requisição veio por AJAX (fetch)
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
               && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            echo json_encode(['success' => $success]); // Retorna JSON em chamadas AJAX
            exit;
        }

        // Redireciona para a página principal após edição full-page
        if ($success) {
            header('Location: index.php?action=home');  // Redireciona ao salvar em tela cheia
            exit;
        } else {
            echo "<script>alert('Erro ao salvar alterações'); window.location.href='index.php?action=home'';</script>";
            exit;
        }
    }

    public function edit(int $id)
    {
        // Busca a reserva pelo ID
        $stmt    = $this->db->prepare("SELECT * FROM reserva WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $reserva = $stmt->fetch(PDO::FETCH_OBJ);

        // Dados para selects
        $espacos      = $this->db->query("SELECT id, nome FROM espaco")->fetchAll(PDO::FETCH_ASSOC);
        $disciplinas  = $this->db->query("SELECT id, nome FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);
        $eventos      = $this->db->query("SELECT id, nome FROM evento")->fetchAll(PDO::FETCH_ASSOC);

        if (!$reserva) {
            echo "<script>alert('Reserva não encontrada!'); window.location.href='index.php?action=home';</script>";
            exit;
        }
        if ($reserva->usuario_id != $_SESSION['usuario_id'] && !isAdmin()) {
            echo "<script>alert('Você não tem permissão para editar esta reserva!'); window.location.href='index.php?action=home';</script>";
            exit;
        }

        return [
            'view' => './src/views/reserva/edit.php',
            'data' => ['reserva' => $reserva, 'espacos' => $espacos, 'disciplinas' => $disciplinas, 'eventos' => $eventos]
        ];
    }

    
    public function delete(int $id)
    {
        $stmt = $this->db->prepare('DELETE FROM reserva WHERE id = :id');
        $stmt->execute(['id'=> $id]);
        
        header('Location: index.php?action=home');
        exit;
    }

    public function confirm()
    {
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;
        $usuarioId = $_SESSION['usuario_id'] ?? null;

        if (!$id || !$usuarioId) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos ou usuário não autenticado']);
            exit;
        }

        $stmt = $this->db->prepare("SELECT id, usuario_id, status, inicio_reserva FROM reserva WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reserva) { // Apenas para verificar mesmo se a reserva existe
            echo json_encode(['success' => false, 'message' => 'Reserva não encontrada!']);
            exit;
        }

        if ($reserva['usuario_id'] != $usuarioId) { // Se outro usuário tentar marcar a reserva como em uso
            echo json_encode(['success' => false, 'message' => 'Você não tem permissão para confirmar esta reserva!']);
            exit;
        }

        if ($reserva['status'] === 'Indisponível') { // Se o botão confirmar der algum problema ou a pessoa achar que não confirmou
            echo json_encode(['success' => false, 'message' => 'Reserva já está confirmada!']);
            exit;
        }

        if ($reserva['status'] !== 'Pendente') { 
            echo json_encode(['success' => false, 'message' => "Reserva com status '{$reserva['status']}' não pode ser confirmada!"]);
            exit;
        }

        $tz = new DateTimeZone('America/Recife'); // Pega o fuso horário de Recife
        $inicio = new DateTime($reserva['inicio_reserva'], $tz); // Hora da reserva
        $agora  = new DateTime('now', $tz); // Hora atual
        $diffSeg = $agora->getTimestamp() - $inicio->getTimestamp();

        if ($diffSeg < 0) { // Se a pessoa tentar confirmar reserva antes da hora, vai ser impedida
            echo json_encode(['success' => false, 'message' => 'Ainda não é hora de confirmar. A reserva começa em ' . $inicio->format('d/m/Y H:i')]);
            exit;
        }

        if ($diffSeg > 15 * 60) { // Durante o tempo-limite de 15 minutos, se ultrapassar a reserva é deletada e o espaço fica disponível.
            $upd = $this->db->prepare("DELETE FROM reserva WHERE id = :id AND status = 'Pendente'");
            $upd->execute(['id' => $id]);
            echo json_encode(['success' => false, 'message' => 'Tempo para confirmação expirou. A reserva foi cancelada.']);
            exit;
        }

        $upd = $this->db->prepare("UPDATE reserva SET status = 'Indisponível' WHERE id = :id AND status = 'Pendente'");
        $upd->execute(['id' => $id]);

        if ($upd->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Reserva confirmada com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Não foi possível confirmar (status já alterado)!']);
        }

        exit;
    }


}
