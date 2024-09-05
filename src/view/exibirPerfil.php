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
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        /* Seu CSS */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            max-width: 100%;
            padding: 20px;
            text-align: center;
        }

        .profile-card img {
            border-radius: 50%;
            width: 250px;
            height: 250px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .profile-card h2 {
            margin: 10px 0;
            font-size: 24px;
            font-weight: 700;
        }

        .profile-card p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .profile-card form input,
        .profile-card form button {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .profile-card form button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            width: 300px;
        }

        .profile-card form button:hover {
            background-color: #218838;
        }

        @media (max-width: 600px) {
            .profile-card {
                width: 90%;
            }
        }

        .section-perfil {
            display: flex;
            margin-top:40px;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<?php require('../../includes/components/header.php')?>
<section class="section-perfil">
    <section class="profile-card">
        <form id="perfilForm" action="../controller/UsuarioController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="acao" value="editarPerfil">
    
            <!-- Exibição da foto do perfil -->
            <img src="../../images/uploads/<?php echo $usuario['imagem']; ?>" alt="Foto do usuário">
    
            <!-- Nome -->
            <h2><?php echo htmlspecialchars($usuario['nome']); ?></h2>
            <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>">
    
            <!-- Email -->
            <p><?php echo htmlspecialchars($usuario['email']); ?></p>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>">
    
            <!-- Atualização de senha -->
            <label for="senha">Alterar senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Nova senha">
    
            <!-- Atualização da foto -->
            <label for="imagem">Alterar foto:</label>
            <input type="file" name="imagem" id="imagem">
    
            <!-- Botão para salvar alterações -->
            <button type="submit">Salvar Alterações</button>
        </form>
    </section>
</section>

</body>
</html>
