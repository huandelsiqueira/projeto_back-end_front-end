<?php
session_start();

include '../controller/MetaController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $dataInicial = $_POST['dataInicial'];
    $dataFim = $_POST['dataFim'];
    $situacao = 'Em Andamento'; // Meta começa sempre como 'Em Andamento'

    // Tratamento de upload de imagem
    // Tratamento de upload de imagem
    $imagem = '';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $imagemNome = uniqid() . '-' . basename($_FILES['imagem']['name']); // Nome único para evitar conflitos
        $caminhoImagem = '../../images/uploads/' . $imagemNome;
        
        // Verifica se o diretório existe, se não, cria
        if (!file_exists('../../images/uploads/')) {
            mkdir('../../images/uploads/', 0777, true);
        }

        // Move o arquivo de upload para o diretório especificado
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
            $imagem = $imagemNome; // Salva o nome da imagem para o banco de dados
        } else {
            echo "Erro ao salvar a imagem. Verifique as permissões da pasta e o caminho.";
            exit; // Adiciona um exit para evitar continuar em caso de erro
        }
    } else {
        echo "Erro no upload da imagem: " . $_FILES['imagem']['error'];
        exit; // Adiciona um exit para evitar continuar em caso de erro
    }


    $controller = new MetaController();
    $controller->adicionarMeta($nome, $descricao, $dataInicial, $dataFim, $situacao, $imagem);

    header('Location: ./paginaMeta.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Criar Meta</title>
</head>
<body>
    <main>
        <h1>Criar Nova Meta</h1>
        <form action="criarMeta.php" method="POST" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>
            
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" required></textarea>
            
            <label for="dataInicial">Data Inicial:</label>
            <input type="date" name="dataInicial" required>
            
            <label for="dataFim">Data Final:</label>
            <input type="date" name="dataFim" required>
            
            <label for="imagem">Imagem:</label>
            <input type="file" name="imagem" accept="image/*">
            
            <button type="submit">Salvar Meta</button>
        </form>
        <button onclick="window.location.href='index.php'">Voltar</button>
    </main>
</body>
</html>
