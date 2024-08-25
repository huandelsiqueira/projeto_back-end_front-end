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
                <p>Organize eventos, promova ações e encontros coletivos!</p>
            </section>
            <img src="../../images/box-index/markus-spiske-5sh24a7m0BU-unsplash.jpg" alt="">
        </section>
        <section id="meio">
            <section class="conteudo">
                <img src="../../images/box-index/box-meta.jpg" alt="">
                <section class="texto">
                    <h3>Metas</h3>
                    <p>Construa uma vida saudável por meio de suas ações e colabore para o desenvolvimento de um mundo mais sustentável!</p>
                </section>
            </section>
        </section>
        <section class="conteudo">
            <section class="texto">
                <h3>Perto de mim</h3>
                <p>Enconte lugares perto de sua localização que irão ajudar na proteção e cuidado ambiental!</p>
            </section>
            <img src="../../images/box-index/box-local.png" alt="">
        </section>
    </section>
    <?php require('../../includes/components/footer.php') ?>
</body>
</html>