<?php

session_start();
require_once __DIR__ . '/../core/conectaDatabase.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Obter o ID do usuário da sessão
$usuario_id = $_SESSION['usuario_id'];

// Obter o ID do evento da URL
$evento_id = $_GET['id'];

// Criar conexão com o banco de dados
$conexao = conectaDatabase();

try {
    // Preparar e executar a instrução SQL para inserir a participação
    $stmt = $conexao->prepare("INSERT INTO participacoes (idUsuario, idEvento) VALUES (:usuario_id, :evento_id)");
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':evento_id', $evento_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Redirecionar para a página de eventos após a inserção bem-sucedida
    header('Location: paginaEvento.php');
    exit();
} catch (PDOException $e) {
    // Em caso de erro, exibir uma mensagem
    echo 'Erro ao participar do evento: ' . $e->getMessage();
}

?>
