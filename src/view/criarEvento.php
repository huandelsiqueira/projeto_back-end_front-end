<?php

require_once __DIR__ . '/../core/conectaDatabase.php';
require_once __DIR__ . '/../controller/EventoController.php';

$controller = new EventoController($conexao);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $evento = new Evento(null, $_POST['nome'], $_POST['descricao'], $_POST['conteudo'], $_POST['data_inicio'], $_POST['data_fim']);
    $controller->criar($evento);
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Criar Evento</title>
</head>
<body>
    <h1>Criar Evento</h1>
    <form method="post">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao" required></textarea><br>

        <label for="conteudo">Conteúdo:</label><br>
        <textarea id="conteudo" name="conteudo" required></textarea><br>

        <label for="data_inicio">Data de Início:</label><br>
        <input type="datetime-local" id="data_inicio" name="data_inicio" required><br>

        <label for="data_fim">Data de Fim:</label><br>
        <input type="datetime-local" id="data_fim" name="data_fim" required><br>

        <button type="submit">Criar Evento</button>
    </form>
</body>
</html>
