<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Cadastro</title>
  <link rel="stylesheet" href="../../public/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <section class="cadastro">
    <section class="formulario-cadastro">
      <form action="../controller/UsuarioController.php" method="post" enctype="multipart/form-data">
        <label for="nome">Nome:</label>
        <br>
        <input type="text" name="nome" id="nome">
        <br>
        <br>
        <label for="email">Email:</label>
        <br>
        <input type="text" name="email" id="email">
        <br>
        <br>
        <label for="senha">Senha:</label>
        <br>
        <input type="password" name="senha" id="senha">
        <br>
        <br>
        <label for="imagem">Foto:</label>
        <br>
        <input type="file" name="imagem" id="imagem">
        <br>
        <br>
        <br>
        <button type="submit" id='cadastrar' name='cadastrar' value="cadastro">Cadastrar</button>
      </form>
      <a href="./index.php"><p>Voltar</p></a>
    </section>
    <section class="imagem-cadastro">
      <h1>ambientalização</h1>
      <p>Sua plataforma de desenvolvimento sustentável!</p>
    </section>
  </section>
<?php require('../../includes/components/footer.php') ?>
</body>
</html>