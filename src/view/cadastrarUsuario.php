<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Cadastro</title>
  <link rel="stylesheet" href="../../public/css/cadastro.css">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <section class="cadastro">
    <section class="formulario-cadastro">
      <form id="cadastroForm" action="../controller/UsuarioController.php" method="post" enctype="multipart/form-data">
        <h1>Faça seu cadastro!</h1>
        <input type="hidden" name="acao" value="cadastro">
        <section class="form-group">
          <label for="nome">Nome:</label>
          <br>
          <input type="text" name="nome" id="nome" placeholder="Seu nome">
        </section>
        <section id="nomeError" class="error-message"></section>
        <br>
        <label for="email">Email:</label>
        <br>
        <input type="text" name="email" id="email" placeholder="usuario@email.com">
        <section id="emailError" class="error-message"></section>
        <br>
        <br>
        <label for="senha">Senha:</label>
        <br>
        <input type="password" name="senha" id="senha" placeholder="********">
        <section id="senhaError" class="error-message"></section>
        <br>
        <br>
        <label for="imagem">Foto:</label>
        <br>
        <input type="file" name="imagem" id="imagem">
        <section id="imagemError" class="error-message"></section>
        <br>
        <br>
        <br>
        <button type="submit" id='cadastrar' name='cadastrar' value="cadastro">Cadastrar</button>
        <a href="./index.php"><p>Voltar</p></a>
      </form>
    </section>
    <section class="imagem-cadastro">
      <h1>ambientalização</h1>
      <p>Sua plataforma de desenvolvimento sustentável!</p>
    </section>
  </section>
  <script src="../../public/js/validacaoDados.js" defer></script>
</body>
</html>