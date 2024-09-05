<?php
// editarMeta.php
session_start();
require_once 'db.php'; // Arquivo com a conexão ao banco de dados
require_once 'Meta.php'; // Modelo Meta com a lógica de salvamento e atualização

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

// Recupera a meta existente do banco de dados
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
    $metaObj->id = $id; // Define o ID para editar a meta existente

    try {
        $metaObj->atualizar($pdo);
        echo "Meta atualizada com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao atualizar meta: " . $e->getMessage();
    }
}
?>

<!-- Formulário de edição da meta -->
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
    <input type="text" name="imagem" value="<?php echo htmlspecialchars($meta['imagem']); ?>"><br>
    
    <button type="submit">Atualizar Meta</button>
</form>
