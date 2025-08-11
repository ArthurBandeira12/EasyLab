<?php
require_once './src/models/TipoEspacoModel.php';

class TipoEspacoController {
    private $model;

    public function __construct($pdo) {
        $this->model = new TipoEspaco($pdo);
    }

    
    public function index() {
        $tipos = $this->model->getAll();
        return [
            'view' => './src/views/tipoespaco/index.php',
            'data' => ['tipos' => $tipos]
        ];
    }

    
    public function create() {
        return ['view' => './src/views/tipoespaco/create.php'];
    }

    
    public function store($postData) {
        $this->model->create($postData['nome']);
        header('Location: index.php?action=tipo-espaco');
        exit;
    }

    
    public function read($id) {
        $tipo = $this->model->getById($id);
        return [
            'view' => './src/views/tipoespaco/read.php',
            'data' => ['tipo' => $tipo]
        ];
    }

    
    public function edit($id) {
        $tipo = $this->model->getById($id);
        return [
            'view' => './src/views/tipoespaco/edit.php',
            'data' => ['tipo' => $tipo]
        ];
    }

    
    public function update($postData) {
        $this->model->update($postData['id'], $postData['nome']);
        header('Location: index.php?action=tipo-espaco');
        exit;
    }

    
    public function delete($id) {
        $tipo = $this->model->getById($id);
        return [
            'view' => './src/views/tipoespaco/delete.php',
            'data' => ['tipo' => $tipo]
        ];
    }

    
    public function destroy($postData) {
        $this->model->delete($postData['id']);
        header('Location: index.php?action=tipo-espaco');
        exit;
    }
}
