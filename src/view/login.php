<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../public/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <title>Página de Login</title>
</head>
<body>
  <main>
    <section class="section-login">
      <section class="image-login">
        <h1>ambientalização</h1>
        <p>Sua plataforma de desenvolvimento sustentável!</p>
      </section>
      <section class="formulario-login">
        <h1>Faça seu login!</h1>
        <form id="loginForm" action="../controller/UsuarioController.php" method="post">
          <input type="hidden" name="acao" value="login">
          <section class="form-group">
            <label for="email">Email:</label>
            <br>
            <input type="text" name="email" id="email" placeholder="usuario@email.com">
            <section id="emailError" class="error-message"></section>
          </section>
          <br>
          <br>
          <section class="form-group">
            <label for="senha">Senha:</label>
            <br>
            <input type="password" name="senha" id="senha" placeholder="********">
            <section id="passwordError" class="error-message"></section>
          </section>
          <br>
          <br>
          <button type="submit" id='login' name='login' value="login">Login</button>
        </form>
        <p>Não possui conta? <a id="cadastre-se" href="../../src/view/cadastrarUsuario.php"><strong>Cadastre-se</strong></a></p>
        <br>
        <a href="./index.php"><p>Voltar</p></a>
      </section>
    </section>
  </main>
  <script src="../../public/js/validacaoDados.js" defer></script>
  <script src="../../public/js/salvarFormulario.js" defer></script>
</body>
</html>