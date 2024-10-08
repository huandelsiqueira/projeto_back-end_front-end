<?php

session_start();

require_once '../model/Usuario.php';
require_once '../core/conectaDatabase.php';

class UsuarioController {

    private $model;

    public function __construct($conexao) {
        $this->model = new Usuario($conexao);
    }

    public function autenticarUsuario($email, $senha) {
        return $this->model->acessarUsuario($email, $senha);
    }

    public function criarOuAtualizarUsuario($nome, $email, $senha, $imagem = null) {
        // Definir extensões permitidas e tamanho máximo (exemplo: 2MB)
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $tamanhoMaximo = 2 * 1024 * 1024; // 2MB
    
        $imagemNome = null; // Inicia a variável da imagem como null
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            // Verifica a extensão do arquivo
            $extensaoImagem = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    
            if (!in_array($extensaoImagem, $extensoesPermitidas)) {
                echo "Erro: Tipo de arquivo não permitido. Apenas JPG, JPEG, PNG e GIF são aceitos.";
                exit();
            }
    
            // Verifica o tamanho do arquivo
            if ($_FILES['imagem']['size'] > $tamanhoMaximo) {
                echo "Erro: O arquivo excede o tamanho máximo permitido de 2MB.";
                exit();
            }
    
            // Verificação se o arquivo enviado é uma imagem
            $check = getimagesize($_FILES['imagem']['tmp_name']);
            if ($check === false) {
                echo "Erro: O arquivo enviado não é uma imagem válida.";
                exit();
            }
    
            // Gerar um nome único para a imagem
            $imagemNome = uniqid() . '-' . basename($_FILES['imagem']['name']);
            $caminhoImagem = '../../images/uploads/' . $imagemNome;
    
            // Verifica se o diretório existe, se não, cria
            if (!file_exists('../../images/uploads/')) {
                mkdir('../../images/uploads/', 0777, true);
            }
    
            // Move o arquivo para o diretório de uploads
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
                $imagem = $imagemNome; // Salva o nome da imagem no banco de dados
            } else {
                echo "Erro ao salvar a imagem. Verifique as permissões da pasta.";
                exit();
            }
        } else {
            // Se nenhuma imagem foi enviada, definir uma imagem padrão
            $imagem = '../../images/uploads/default.webp'; // Nome da imagem padrão
        }
    
        // Cria o objeto para o usuário
        $usuario = new stdClass();
        $usuario->nome = $nome;
        $usuario->email = $email;
        $usuario->senha = $senha;
        $usuario->imagem = $imagem; // Associa a imagem ao usuário
    
        return $this->model->inserirUsuario($usuario);
    }
    
    
    

    // Adicionando o método atualizarPerfil
    public function atualizarPerfil($id, $nome, $email, $senha, $imagem = null) {
        // Obtém o usuário atual do banco de dados para recuperar a senha e imagem antigas
        $usuarioAtual = $this->model->buscarUsuarioPorId($id);
        
        // Verifica se uma nova senha foi fornecida, caso contrário, mantém a senha antiga
        if (empty($senha)) {
            $senha = $usuarioAtual['senha']; // Mantém a senha antiga
        } else {
            // Caso queira adicionar hash de senha, pode fazer isso aqui, por exemplo:
            // $senha = password_hash($senha, PASSWORD_DEFAULT);
        }
    
        // Verifica se uma nova imagem foi enviada, caso contrário, mantém a imagem antiga
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            $imagemNome = uniqid() . '-' . basename($_FILES['imagem']['name']);
            $caminhoImagem = '../../images/uploads/' . $imagemNome;
            
            if (!file_exists('../../images/uploads/')) {
                mkdir('../../images/uploads/', 0777, true);
            }
    
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
                $imagem = $imagemNome;
            } else {
                echo "Erro ao salvar a imagem. Verifique as permissões da pasta.";
                exit();
            }
        } else {
            // Mantém a imagem atual se nenhuma nova for enviada
            $imagem = $usuarioAtual['imagem'];
        }
    
        // Atualiza o usuário no banco de dados
        return $this->model->atualizarUsuario($id, $nome, $email, $senha, $imagem);
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
                header("Location: ../view/login.php");
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        }
    } elseif ($acao === 'editarPerfil') {
        // Processa a edição de perfil
        $nome = $_POST['nome'] ?? null;
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;
        $imagem = $_FILES['imagem']['name'] ?? null;
    
            $idUsuario = $_SESSION['usuario_id']; // Pega o ID do usuário logado
            $resultado = $controller->atualizarPerfil($idUsuario, $nome, $email, $senha, $imagem);
            if ($resultado) {
                $_SESSION['usuario_nome'] = $nome;
                // Redireciona para a mesma página de exibição de perfil após atualizar
                header("Location: ../view/exibirPerfil.php");
                exit();
            } else {
                echo "Erro ao atualizar perfil.";
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
