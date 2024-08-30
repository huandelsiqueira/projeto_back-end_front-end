<?php

session_start();
require_once __DIR__ . '/../core/conectaDatabase.php';
require_once __DIR__ . '/../controller/EventoController.php';

$controller = new EventoController($conexao);
$eventos = $controller->listar();

$usuario_logado_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <h1>Lista de Eventos</h1>
    
    <?php if ($usuario_logado_id): ?>
        <a href="criarEvento.php">Criar Novo Evento</a>
    <?php endif; ?>
        
    <ul>
    <?php foreach ($eventos as $evento): ?>
        <li class="event-box">
            <img src="caminho_para_imagem_do_evento.jpg" alt="Imagem do evento">
            <div class="event-info">
                <h2><?= htmlspecialchars($evento->nome) ?></h2>
                <p><strong>Descrição:</strong> <?= htmlspecialchars($evento->descricao) ?></p>
                <p><strong>Conteúdo:</strong> <?= htmlspecialchars($evento->conteudo) ?></p>
                <p><strong>Data de Início:</strong> <?= htmlspecialchars(date('d/m/Y H:i', strtotime($evento->data_inicio))) ?></p>
                <p><strong>Data de Fim:</strong> <?= htmlspecialchars(date('d/m/Y H:i', strtotime($evento->data_fim))) ?></p>
                
                <?php if ($usuario_logado_id && $evento->idUsuario == $usuario_logado_id): ?>
                    <a href="editarEvento.php?id=<?= htmlspecialchars($evento->idevento) ?>">Editar</a>
                <?php endif; ?>

                <?php if ($usuario_logado_id && $evento->idUsuario != $usuario_logado_id): ?>
                    <a href="participarEvento.php?id=<?= htmlspecialchars($evento->idevento) ?>">Participar</a>
                <?php endif; ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

</body>
</html>
