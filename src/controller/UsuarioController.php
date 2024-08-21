<?php

class UsuarioController {

    private $model;

    public function __construct($model) {

        $this->model = $model;

    }

    public function criarOuAtualizarUsuario($id, $nome, $email) {

        if ($id) {

            $this->model->setId($id);

        }
        
        $this->model->setNome($nome);
        $this->model->setEmail($email);
        $this->model->salvar();
    }
}

?>