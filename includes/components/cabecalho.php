<?php

session_start();
if(!$_SESSION['logado']) {

	header('location:index.php');

} else {

    header('location:cadastrarUsuario.php');

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="assets/js/validacao.js"></script>
</head>
<body>
    
</body>
</html>