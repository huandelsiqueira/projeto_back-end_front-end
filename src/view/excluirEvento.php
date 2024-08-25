<?php

require_once __DIR__ . '/../core/conectaDatabase.php';
require_once __DIR__ . '/../controller/EventoController.php';

if (isset($_GET['id'])) {
    $controller = new EventoController($conexao);
    $controller->deletar($_GET['id']);
}

header('Location: index.php');
exit();

?>
