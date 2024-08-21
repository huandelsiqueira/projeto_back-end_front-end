<?php

require_once '../model/Usuario.php';
require_once '../core/conectaDatabase.php';

class UsuarioController {

    private $model;

    public function __construct($conexao) {
        $this->model = new Usuario($conexao);
    }

    public function criarOuAtualizarUsuario($nome, $email, $senha, $imagem = null) {
        $usuario = new stdClass();
        $usuario->nome = $nome;
        $usuario->email = $email;
        $usuario->senha = $senha;
        $usuario->imagem = $imagem;
        
        return $this->model->inserirUsuario($usuario);
    }
}

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? null;
    $email = $_POST['email'] ?? null;
    $senha = $_POST['senha'] ?? null;
    $imagem = $_FILES['imagem']['name'] ?? null;

    // Inicializa a conexão
    $conexao = new PDO("mysql:host=localhost; dbname=projeto; charset=utf8", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Inicializa o controlador com a conexão
    $controller = new UsuarioController($conexao);

    // Insere o usuário
    $resultado = $controller->criarOuAtualizarUsuario($nome, $email, $senha, $imagem);

    if ($resultado) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário.";
    }
}

?>