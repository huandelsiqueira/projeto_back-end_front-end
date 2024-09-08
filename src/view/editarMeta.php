<?php
session_start();
require_once __DIR__ . '/../controller/MetaController.php';
require_once __DIR__ . '/../model/Meta.php';
require_once __DIR__ . '/../core/conectaDatabase.php'; // Inclui o ficheiro de conexão com a base de dados

// Inicializa a conexão com a base de dados
$pdo = conectaDatabase(); // Chama a função para obter a conexão PDO

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "Você precisa estar logado para editar uma meta.";
    exit;
}

// Recupera o ID da meta a partir da URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID da meta não especificado.";
    exit;
}

// Recupera a meta existente do banco de dados, passando a conexão $pdo
$meta = Meta::buscarPorId($pdo, $id);

// Verifica se a meta existe e se o usuário logado é o criador
if (!$meta || $meta['criador_id'] != $_SESSION['usuario_id']) {
    echo "Meta não encontrada ou você não tem permissão para editá-la.";
    exit;
}

// Se o formulário foi submetido, atualiza a meta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $dataInicial = $_POST['dataInicial'];
    $dataFim = $_POST['dataFim'];
    $situacao = $_POST['situacao'];
    $imagem = $_POST['imagem'];

    $metaObj = new Meta($nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem, $meta['criador_id']);
    $metaObj->setId($id); // Define o ID para editar a meta existente

    try {
        $metaObj->atualizar($pdo); // Passa a conexão $pdo ao método atualizar
        echo "Meta atualizada com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao atualizar meta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/editarMeta.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Editar meta</title>
</head>
<body>
    
    <section class="formulario-editarMeta">
        <section class="image-editarMeta">
            <img src="../../images/uploads/<?php echo $meta['imagem']; ?>" alt="Foto do usuário">
        </section>
        <form method="post">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($meta['nome']); ?>" required><br>
        
            <label>Descrição:</label>
            <textarea name="descricao" required><?php echo htmlspecialchars($meta['descricao']); ?></textarea><br>
        
            <label>Data Inicial:</label>
            <input type="date" name="dataInicial" value="<?php echo $meta['dataInicial']; ?>" required><br>
        
            <label>Data Fim:</label>
            <input type="date" name="dataFim" value="<?php echo $meta['dataFim']; ?>" required><br>
        
            <label>Situação:</label>
            <input type="text" name="situacao" value="<?php echo htmlspecialchars($meta['situacao']); ?>" required><br>
        
            <label>Imagem:</label>
            <input type="file" name="imagem" value="<?php echo htmlspecialchars($meta['imagem']); ?>"><br>
        
            <button type="submit">Atualizar Meta</button>
        </form>
    </section>
</body>
</html>
<!-- Formulário de edição da meta -->

