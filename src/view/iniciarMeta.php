<?php
session_start();
include '../controller/MetaController.php';

$controller = new MetaController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $controller->iniciarMeta($id);
        header('Location: ./paginaMeta.php');
        exit();
    } catch (Exception $e) {
        echo "Erro ao iniciar a meta: " . $e->getMessage();
    }
} else {
    echo "ID da meta não fornecido.";
}
?>
?>