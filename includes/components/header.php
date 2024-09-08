<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
} // Para depuração

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/header.css">
</head>
<body>
<header>
    <nav class="nav-header">
        <a href="./index.php"><img src="../../images/logomarca/logomarca.svg" alt="Logomarca do sistema 'Ambientalização'" class="img-nav-header" title="Logomarca do sistema 'Ambientalização'"></a>
        <ul>
            <li><a href="#">Sobre</a></li>
            <li><a href="../../src/view/paginaMeta.php">Metas</a></li>
            <li><a href="../../src/view/paginaEvento.php">Eventos</a></li>
            <li><a href="../../src/view/minhaLocalizacao.php">Perto de mim</a></li>
            <?php if (isset($_SESSION['usuario_nome'])): ?>
                <li class="bem-vindo">Bem-vindo, <a id="perfil" href="../../src/view/exibirPerfil.php"> <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></a></li>
                <li><a href="../controller/UsuarioController.php?acao=logout">Logout</a></li>
            <?php else: ?>
                <li><a href="../../src/view/login.php">Login</a></li>
                <li><a href="../../src/view/cadastrarUsuario.php">Cadastre-se</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
</body>
</html>