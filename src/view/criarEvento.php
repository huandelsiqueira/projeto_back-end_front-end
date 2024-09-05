<?php

require_once __DIR__ . '/../controller/EventoController.php';
require_once __DIR__ . '/../model/Evento.php';
require_once __DIR__ . '/../core/conectaDatabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $conteudo = $_POST['conteudo'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    if (empty($data_fim)) {
        echo "Erro: A data de fim não pode ser nula.";
        exit;
    }

    $evento = new Evento();
    $evento->nome = $nome;
    $evento->descricao = $descricao;
    $evento->conteudo = $conteudo;
    $evento->data_inicio = $data_inicio;
    $evento->data_fim = $data_fim;

    $conexao = conectaDatabase();
    $eventoController = new EventoController($conexao);

    if ($eventoController->criar($evento)) {
        header("Location: ../view/paginaEvento.php");
    } else {
        echo "Erro ao criar o evento.";
    }
}


?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Evento</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <section class="criar-evento-container">
        <!-- Seção da imagem -->
        <section class="evento-imagem">
        </section>

        <!-- Seção do formulário -->
        <section class="evento-form">
            <h1>Crie seu evento!</h1>
            <section class="form-evento">
                <form method="post">
                    <label for="evento-nome">Nome do Evento:</label><br>
                    <input type="text" id="evento-nome" name="nome" required><br>
                    <label for="evento-descricao">Descrição:</label><br>
                    <textarea id="evento-descricao" name="descricao" required></textarea><br>
                    <label for="evento-conteudo">Conteúdo:</label><br>
                    <textarea id="evento-conteudo" name="conteudo" required></textarea><br>
                    <label for="evento-data-inicio">Data de Início:</label><br>
                    <input type="date" id="evento-data-inicio" name="data_inicio" required><br>
                    <label for="evento-data-fim">Data de Fim:</label><br>
                    <input type="date" id="evento-data-fim" name="data_fim" required><br>
                    <button type="submit">Criar Evento</button>
                </form>
            </section>
        </section>
    </section>
</body>
</html>
