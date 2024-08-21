<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Login</title>
</head>
<body>
  <main>
    <section>
      
    </section>
    <section>
      <section>
        <a href="./index.php"><img src="../../images/logomarca/logomarca.svg" alt="Logomarca do sistema 'Ambientalização'" title="Logomarca do sistema 'Ambientalização'"></a>
        <img src="../../images/background/geranimo-qzgN45hseN0-unsplash.webp">
      </section>
      <section>
        <form action="includes/logica/logica_pessoa.php" method="post">
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
          <button type="submit" id='entrar' name='entrar' value="Entrar">Login</button>
        </form>
        <p>Não possui conta? <a href="../../src/view/cadastrarUsuario.php"><strong>Cadastre-se</strong></a></p>
      </section>
    </section>
  </main>
</body>
</html>