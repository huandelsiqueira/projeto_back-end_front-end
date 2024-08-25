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
        <form action="../controller/UsuarioController.php" method="post">
          <input type="hidden" name="acao" value="login">
          <label for="email">Email:</label>
          <br>
          <input type="text" name="email" id="email" placeholder="usuario@email.com">
          <br>
          <br>
          <label for="senha">Senha:</label>
          <br>
          <input type="password" name="senha" id="senha" placeholder="********">
          <br>
          <br>
          <button type="submit" id='login' name='login' value="login">Login</button>
        </form>
        <p>Não possui conta? <a href="../../src/view/cadastrarUsuario.php"><strong>Cadastre-se</strong></a></p>
      </section>
    </section>
  </main>
</body>
</html>