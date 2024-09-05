<?php
// excluirMeta.php
// excluirMeta.php
session_start();
require_once __DIR__ . '/../controller/MetaController.php'; // Inclui o controlador de Meta

$controller = new MetaController();

// Verifica se o ID da meta foi fornecido na URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID da meta não especificado.";
    exit;
}

try {
    // Chama o método do controlador para excluir a meta
    $controller->excluirMeta($id);
    header("Location: ../view/paginaMeta.php");
} catch (Exception $e) {
    echo "Erro ao excluir meta: " . $e->getMessage();
}

?>