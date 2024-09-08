<?php

session_start();

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
<style>
    /* Container da imagem do evento */
.evento-imagem {
  flex: 1;
  background-image: url(../../images/background/event-background.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}

.evento-imagem::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
}

.evento-imagem h1, .evento-imagem p {
  position: relative;
  color: white;
  text-align: center;
  z-index: 2;
}

.evento-imagem h1 {
  font-family: 'Josefin Sans', sans-serif;
  font-size: 4rem;
  margin-bottom: 20px;
}

.evento-imagem p {
  font-size: 1.5rem;
}

/* Seção do formulário de evento */
.evento-form {
  flex: 1.5;
  max-width: 800px;
  padding: 50px 40px;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
}

/* Formulário */
.form-evento {
  width: 100%; /* Ajusta para ocupar toda a largura disponível */
  max-width: 580px; /* Limita o tamanho do formulário */
}

/* Cabeçalho do formulário */
.evento-form h1 {
  font-size: 32px;
  margin-bottom: 24px;
  font-family: 'Josefin Sans', sans-serif;
  align-self: flex-start;
}

/* Labels e campos do formulário */
.evento-form form label {
  margin-top: 10px;
  margin-bottom: 5px;
  color: #333;
  font-size: 1rem;
  font-weight: bold;
}

.evento-form input,
.evento-form textarea {
  width: 100%; /* Ajusta a largura para 100% do contêiner pai */
  max-width: 580px; /* Limita a largura máxima */
  padding: 12px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 1rem;
}

.evento-form textarea {
  resize: vertical;
  height: 100px;
}

/* Botão de envio */
.evento-form button {
  width: 100%; /* O botão ocupa toda a largura */
  max-width: 580px; /* Limita a largura máxima */
  padding: 14px;
  background-color: #374B47;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1.1rem;
  margin-top: 20px;
  align-self: center; /* Centraliza o botão com os inputs */
}

.evento-form button:hover {
  background-color: #2d4c3c;
}

/* Responsividade */
@media (max-width: 768px) {
  .evento-form {
    padding: 30px 20px;
  }

  .evento-imagem h1 {
    font-size: 2.5rem; /* Reduz o tamanho da fonte em telas menores */
  }

  .evento-imagem p {
    font-size: 1.2rem; /* Ajusta o tamanho do texto */
  }

  .evento-form h1 {
    font-size: 28px; /* Ajusta o título do formulário */
  }

  .evento-form input,
  .evento-form textarea,
  .evento-form button {
    max-width: 100%; /* Garante que ocupem toda a largura em telas pequenas */
  }
}

@media (max-width: 480px) {
  .evento-imagem h1 {
    font-size: 2rem; /* Reduz ainda mais em telas muito pequenas */
  }

  .evento-imagem p {
    font-size: 1rem;
  }

  .evento-form {
    padding: 20px 15px; /* Ajusta o padding para telas muito pequenas */
  }
}

</style>
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
