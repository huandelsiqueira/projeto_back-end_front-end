<?php

session_start();

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

    public function autenticarUsuario($email, $senha) {

        return $this->model->acessarUsuario($email, $senha);

    }
}

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? ''; // Verificar a ação
    $email = $_POST['email'] ?? null;
    $senha = $_POST['senha'] ?? null;

    // Inicializa a conexão
    $conexao = new PDO("mysql:host=localhost; dbname=projeto; charset=utf8", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Inicializa o controlador com a conexão
    $controller = new UsuarioController($conexao);

    // Verifica a ação e executa o código apropriado
    if ($acao === 'login') {
        // Processa o login
        $usuario = $controller->autenticarUsuario($email, $senha);
        if ($usuario) {
            // Armazena as informações do usuário na sessão
            $_SESSION['usuario_id'] = $usuario['idusuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];

            // Redireciona para a página principal ou dashboard
            header("Location: ../view/index.php");
            exit();
        } else {
            echo "Credenciais inválidas.";
        }
    } elseif ($acao === 'cadastro') {
        // Processa o cadastro
        $nome = $_POST['nome'] ?? null;
        $imagem = $_FILES['imagem']['name'] ?? null;
        
        if (empty($nome)) {
            echo "Erro: O campo nome é obrigatório.";
        } else {
            $resultado = $controller->criarOuAtualizarUsuario($nome, $email, $senha, $imagem);
            if ($resultado) {
                echo "Usuário cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        }
    }
}

// Lógica de logout fora do bloco POST
if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
    session_start();
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destrói a sessão
    header("Location: ../view/index.php"); // Redireciona para a página de login
    exit();
}

?>