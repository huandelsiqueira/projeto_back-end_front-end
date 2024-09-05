<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Ambientalização</title>
</head>
<body>
    <section class="secao-img-pagina-inicial">
    <?php require('../../includes/components/header.php')?>
            <h1>ambientalização</h1>
            <p>Sua plataforma de desenvolvimento sustentável!</p>
        <br>
        <input type="search" id="search" name="search" placeholder="Procurar...">
    </section>
    <section class="secao-conteudo">
        <section class="conteudo">
            <section class="texto">
                <h3>Eventos</h3>
                <p>Participe de atividades ambientais, como oficinas, palestras e mutirões de limpeza, que promovem a conscientização e ação coletiva. Os eventos reúnem pessoas comprometidas em proteger o meio ambiente, proporcionando aprendizado e troca de experiências sobre práticas sustentáveis.</p>
            </section>
            <img src="../../images/box-index/markus-spiske-5sh24a7m0BU-unsplash.jpg" alt="">
        </section>
        <section id="meio">
            <section class="conteudo">
                <img src="../../images/box-index/box-meta.jpg" alt="">
                <section class="texto">
                    <h3>Metas</h3>
                    <p>Adote pequenas ações no seu dia a dia para construir uma vida mais saudável e sustentável. Cada passo contribui para a redução do impacto ambiental e o desenvolvimento de um mundo mais equilibrado, com foco no bem-estar e na preservação dos recursos naturais.</p>
                </section>
            </section>
        </section>
        <section class="conteudo">
            <section class="texto">
                <h3>Perto de mim</h3>
                <p>Descubra locais próximos à sua comunidade que promovem iniciativas verdes, como parques, centros de reciclagem ou hortas comunitárias. Esses lugares são ideais para se envolver em ações de proteção ambiental e fomentar uma cultura de cuidado com o planeta.</p>
            </section>
            <img src="../../images/box-index/box-local.png" alt="">
        </section>
    </section>
    <?php require('../../includes/components/footer.php') ?>
    <script src="../../public/js/footer.js"></script>
</body>
</html>