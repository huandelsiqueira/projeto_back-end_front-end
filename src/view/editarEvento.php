<?php

require_once __DIR__ . '/../core/conectaDatabase.php';
require_once __DIR__ . '/../controller/EventoController.php';

$controller = new EventoController($conexao);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $evento = new Evento($_POST['idevento'], $_POST['nome'], $_POST['descricao'], $_POST['conteudo'], $_POST['data_inicio'], $_POST['data_fim']);
    $controller->atualizar($evento);
    header('Location: index.php');  
    exit();
} elseif (isset($_GET['id'])) {
    $evento = $controller->buscar($_GET['id']);
    if (!$evento) {
        echo "Evento não encontrado.";
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
</head>
<body>
    <h1>Editar Evento</h1>
    <form method="post">
        <input type="hidden" name="idevento" value="<?= htmlspecialchars($evento->idevento) ?>">

        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($evento->nome) ?>" required><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao" required><?= htmlspecialchars($evento->descricao) ?></textarea><br>

        <label for="conteudo">Conteúdo:</label><br>
        <textarea id="conteudo" name="conteudo" required><?= htmlspecialchars($evento->conteudo) ?></textarea><br>

        <label for="data_inicio">Data de Início:</label><br>
        <input type="datetime-local" id="data_inicio" name="data_inicio" value="<?= htmlspecialchars($evento->data_inicio) ?>" required><br>

        <label for="data_fim">Data de Fim:</label><br>
        <input type="datetime-local" id="data_fim" name="data_fim" value="<?= htmlspecialchars($evento->data_fim) ?>" required><br>

        <button type="submit">Salvar Alterações</button>
        <a href="excluirEvento.php?id=<?= htmlspecialchars($evento->idevento) ?>" onclick="return confirm('Tem a certeza que deseja excluir este evento?')">Excluir Evento</a>
    </form>
</body>
</html>
