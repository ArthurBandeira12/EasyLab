<?php
require_once './src/models/Tipo-Espaco.php';

class TipoEspacoController
{
    private $model;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->model = new TipoEspaco($db);
    }

    public function index()
    {
        $tipos = $this->model->getAll();

        return [
            'view' => './src/views/tipoespaco/index.php',
            'data' => ['tipos' => $tipos]
        ];
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $this->model->nome = $nome;

            if ($this->model->create()) {
                // Depois de criar, lista tudo de novo
                return $this->index();
            } else {
                return [
                    'view' => './src/views/tipoespaco/create.php',
                    'data' => ['erro' => 'Erro ao criar o tipo de espaço.']
                ];
            }
        }
        // Se GET, mostra o formulário
        return [
            'view' => './src/views/tipoespaco/create.php',
            'data' => []
        ];
    }

    public function read(int $id = 0)
    {
        $this->model->id = $id;

        if ($this->model->read()) {
            $tipo = [
                'id' => $this->model->id,
                'nome' => $this->model->nome
            ];
            return [
                'view' => './src/views/tipoespaco/read.php',
                'data' => ['tipo' => $tipo]
            ];
        }
        return [
            'view' => './src/views/tipoespaco/index.php',
            'data' => ['tipos' => $this->model->getAll(), 'erro' => 'Tipo de espaço não encontrado.']
        ];
    }

    public function edit(int $id = 0)
    {
        $this->model->id = $id;

        if ($this->model->read()) {
            $tipo = [
                'id' => $this->model->id,
                'nome' => $this->model->nome
            ];
            return [
                'view' => './src/views/tipoespaco/edit.php',
                'data' => ['tipo' => $tipo]
            ];
        }
        return [
            'view' => './src/views/tipoespaco/index.php',
            'data' => ['tipos' => $this->model->getAll(), 'erro' => 'Tipo de espaço não encontrado.']
        ];
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $nome = $_POST['nome'] ?? '';

            $this->model->id = (int)$id;
            $this->model->nome = $nome;

            if ($this->model->update()) {
                return $this->index();
            } else {
                return [
                    'view' => './src/views/tipoespaco/edit.php',
                    'data' => ['tipo' => ['id' => $id, 'nome' => $nome], 'erro' => 'Erro ao atualizar o tipo de espaço.']
                ];
            }
        }
        // Caso não seja POST, redirecionar para lista
        return $this->index();
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $this->model->id = (int)$id;

            if ($this->model->delete()) {
                return $this->index();
            } else {
                return [
                    'view' => './src/views/tipoespaco/index.php',
                    'data' => ['tipos' => $this->model->getAll(), 'erro' => 'Erro ao deletar o tipo de espaço.']
                ];
            }
        }
        return $this->index();
    }
}
