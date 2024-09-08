<?php
session_start(); // Inicia a sessão para verificar se o usuário está logado
include '../controller/MetaController.php';

$controller = new MetaController();
$metas = $controller->listarMetas();
$usuarioLogado = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null; // Obter ID do usuário logado, se existir
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Minhas Metas</title>
</head>
<body>
    <main>
        <?php require('../../includes/components/header.php')?>
        <h1 id="titulo-pagina-meta">Metas sustentáveis</h1>
        <?php if ($usuarioLogado): ?>
            <a href="criarMeta.php">
                <section class="botao-criar-meta"><p>Criar Nova Meta</p></section>
            </a>
        <?php endif; ?>
        <section class="metas-grid">
        <?php foreach ($metas as $meta): ?>
    <section class="meta-card" style="background-image: url('../../images/uploads/<?php echo htmlspecialchars($meta['imagem']); ?>');">
        <h2><?php echo htmlspecialchars($meta['nome']); ?></h2>
        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($meta['descricao']); ?></p>
        <p><strong>Data inicial: </strong><?php echo date('d/m/Y', strtotime($meta['dataInicial'])); ?></p>
        <p><strong>Data final: </strong><?php echo date('d/m/Y', strtotime($meta['dataFim'])); ?></p>
        <strong>
            <p class="<?php echo $meta['situacao'] == 'Realizada' ? 'status-realizada' : ($meta['situacao'] == 'Em Andamento' ? 'status-andamento' : 'status-nao-iniciada'); ?>">
            <?php 
                if ($meta['situacao'] == 'Realizada') {
                    echo 'Realizada';
                } elseif ($meta['situacao'] == 'Em Andamento') {
                    echo 'Em Andamento';
                } else {
                    echo 'Não Iniciada';
                }
            ?>
            </p>
        </strong>

        <!-- Botões de ação -->
        <?php if ($usuarioLogado && $usuarioLogado == $meta['criador_id']): ?>
            <section class="botoes-meta">
                <!-- Botão "Iniciar Meta" aparece se o status for "Não Iniciada" -->
                <?php if ($meta['situacao'] == 'Não Iniciada'): ?>
                    <a id="iniciar" href="./iniciarMeta.php?id=<?php echo $meta['id']; ?>">Iniciar Meta</a>
                <?php endif; ?>
                
                <!-- Botão "Concluir" aparece se o status for "Em Andamento" -->
                <?php if ($meta['situacao'] == 'Em Andamento'): ?>
                    <a id="concluir" href="./concluirMeta.php?id=<?php echo $meta['id']; ?>" onclick="return confirm('Tem certeza que deseja marcar como realizada?');">Concluir</a>
                <?php endif; ?>

                <!-- Botões de editar e excluir -->
                <a id="editar" href="./editarMeta.php?id=<?php echo $meta['id']; ?>">Editar</a>
                <a id="excluir" href="./excluirMeta.php?id=<?php echo $meta['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
            </section>
        <?php endif; ?>
            </section>
        <?php endforeach; ?>
        </section>
    </main>

    <!-- Script para exibir a mensagem -->
    <script src="../../public/js/validarExclusao/Meta.js"></script>
</body>
</html>
