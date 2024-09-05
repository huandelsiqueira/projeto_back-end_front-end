<?php
session_start();
require_once __DIR__ . '/../core/conectaDatabase.php';
require_once __DIR__ . '/../controller/EventoController.php';
require_once __DIR__ . '/../model/Evento.php';

// Verificar se o usuário está logado e definir a variável $usuario_logado_id
$usuario_logado_id = null; // Inicialize a variável como null por padrão
if (isset($_SESSION['usuario_id'])) {
    $usuario_logado_id = $_SESSION['usuario_id'];
}

// Criando conexão com o banco de dados
$conexao = conectaDatabase();

// Instanciando o controlador de eventos
$eventoController = new EventoController($conexao);

// Listando eventos
$eventos = $eventoController->listar();

// Verificando se $eventos é um array ou um objeto
if (!is_array($eventos) && !is_object($eventos)) {
    $eventos = []; // Inicialize $eventos como array vazio se não for um array ou objeto
}
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<style>
        /* Adicione este CSS para criar um layout em grid */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: left;
            margin: 30px;
            color: #374B47;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .event-box {
            background-color: #fff;
            position: relative;
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #fff;
            padding: 20px;
            margin: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 250px;
            transition: transform 0.3s;
        }

        .event-info h2 {
            margin-top: 0;
            color: #159631;
        }

        .event-info p {
            margin: 10px 0;
            color: #555;
        }

        .event-info a {
            text-decoration: none;
            color: #fff;
            background-color: #2d4c3c;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
            margin-top: 10px;
        }

        .event-info a:hover {
            background-color: #159631;
        }

        .botao-participar-evento {
            background-color: #159631;
            margin: 30px;
            padding: 10px;
            width: 20%;
            text-align: center;
            font-size: 1.2em;
            color: white;
            border-radius: 5px;
        }

        .botao-participar-evento:hover {
            background-color: #2d4c3c;
        }

        .participando {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #159631;
            padding: 5px;
            border-radius: 5px;
            width: 250px;
        }

        .participando img {
            width: 30px;
            height: 30px;
        }

        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>
<body>
    <?php require('../../includes/components/header.php')?>

    <h1>Lista de Eventos</h1>
    
    <?php if ($usuario_logado_id): ?>
        <a href="criarEvento.php">
            <section class="botao-participar-evento"><p>Criar Novo Evento</p></section>
        </a>
    <?php endif; ?>
        
    <ul>
    <?php foreach ($eventos as $evento): ?>
    <?php
    $usuarioParticipando = $usuario_logado_id ? $eventoController->verificarParticipacao($usuario_logado_id, $evento->idevento) : false;
    ?>
    <li class="event-box">
        <section class="event-info">
            <h2><?= htmlspecialchars($evento->nome) ?></h2>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($evento->descricao) ?></p>
            <p><strong>Conteúdo:</strong> <?= htmlspecialchars($evento->conteudo) ?></p>
            <p><strong>Data de Início:</strong> <?= htmlspecialchars(date('d/m/Y', strtotime($evento->data_inicio))) ?></p>
            <p><strong>Data de Fim:</strong> <?= htmlspecialchars(date('d/m/Y', strtotime($evento->data_fim))) ?></p>
            
            <?php if ($usuario_logado_id && $evento->idUsuario == $usuario_logado_id): ?>
                <a href="editarEvento.php?id=<?= htmlspecialchars($evento->idevento) ?>">Editar</a>
                <a href="excluirEvento.php?id=<?= htmlspecialchars($evento->idevento) ?>">Excluir Evento</a>
            <?php elseif ($usuario_logado_id && !$usuarioParticipando): ?>
                <a href="participarEvento.php?id=<?= htmlspecialchars($evento->idevento) ?>">Participar</a>
            <?php elseif ($usuario_logado_id && $usuarioParticipando): ?>
                <section class="participando"><img src="https://img.icons8.com/?size=100&id=11221&format=png&color=159631" alt=""><p>Participando do evento</p></section>
            <?php endif; ?>
        </section>
    </li>
    <?php endforeach; ?>
    </ul>

</body>
</html>
