<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die('Erro: Usuário não logado.');
}

// Conectar ao banco de dados
include_once '../core/conectaDatabase.php'; // Certifique-se que este arquivo contém a conexão com o BD
$conexao = conectaDatabase(); // Cria a conexão com o banco de dados, supondo que `conectaDatabase` retorne a conexão PDO.

// Inclui o modelo do usuário
include_once '../model/Usuario.php';

// Obter o ID do usuário logado
$usuarioId = $_SESSION['usuario_id'];

// Consultar os dados do usuário no banco
$usuarioModel = new Usuario($conexao);
$usuario = $usuarioModel->buscarUsuarioPorId($usuarioId);

if (!$usuario) {
    die('Erro: Usuário não encontrado.');
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha os dados do formulário
    $nome = $_POST['nome'] ?? null;
    $email = $_POST['email'] ?? null;
    $senha = $_POST['senha'] ?? null;

    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemNome = $_FILES['imagem']['name'];
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        
        // Define o diretório onde a imagem será armazenada
        $destino = '../uploads/' . $imagemNome;

        // Move a imagem para o diretório de uploads
        move_uploaded_file($imagemTmp, $destino);
    } else {
        // Se não for enviada uma nova imagem, mantenha a imagem anterior
        $imagemNome = $usuario['imagem']; // Nome da imagem atual do banco de dados
    }

    // Chame o método para atualizar o usuário no banco de dados
    $usuarioModel->atualizarUsuario($usuarioId, $nome, $email, $senha, $imagemNome);

    // Redirecione ou exiba uma mensagem de sucesso
    header('Location: exibirPerfil.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuário</title>
    <link rel="stylesheet" href="../../public/css/perfil.css">
</head>
<body>
<?php require('../../includes/components/header.php')?>
<section class="section-perfil">
    <section class="profile-card">
    <img src="../../images/uploads/<?php echo $usuario['imagem']; ?>" alt="Foto do usuário">
        <form id="perfilForm" action="../controller/UsuarioController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="acao" value="editarPerfil">
    
            <!-- Exibição da foto do perfil -->
            
            <!-- Nome -->
             <br>
            <label for="nome"><strong>Nome:</strong></label>
            <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>">
    
            <!-- Email -->
            <label for="email"><strong>Email:</strong></label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>">
    
            <!-- Atualização de senha -->
            <label for="senha"><strong>Senha:</strong></label>
            <input type="password" name="senha" id="senha" placeholder="Nova senha">
    
            <!-- Atualização da foto -->
            <label for="imagem"><strong>Foto:</strong></label>
            <input type="file" name="imagem" id="imagem">
    
            <!-- Botão para salvar alterações -->
            <button type="submit">Salvar Alterações</button>
        </form>
    </section>
</section>
</body>
</html>
