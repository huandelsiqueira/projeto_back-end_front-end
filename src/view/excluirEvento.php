<?php
session_start();
require_once __DIR__ . '/../core/conectaDatabase.php';
require_once __DIR__ . '/../controller/EventoController.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_logado_id = $_SESSION['usuario_id'];

if (isset($_GET['id'])) {
    $idevento = $_GET['id'];
    
    // Criando conexão com o banco de dados
    $conexao = conectaDatabase();
    $eventoController = new EventoController($conexao);
    
    // Buscar o evento para garantir que o usuário logado é o dono
    $evento = $eventoController->buscar($idevento);
    
    if ($evento && $evento->idUsuario == $usuario_logado_id) {
        // Excluir o evento
        $eventoController->deletar($idevento);
    }
}

header('Location: páginaEvento.php');
exit();
?>
