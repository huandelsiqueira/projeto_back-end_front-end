<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locais de Coleta e Reciclagem</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>

        * {
            font-family: 'Montserrat', sans-serif;
        }

        .minhaLocalizacao {
            display: flex;
            gap: 10px;
        }

        .texto-minhaLocalizacao {
            width: 23%;
            padding: 10px;
            border-radius: 20px;
            background-color: rgb(216, 216, 216);
        }

        .texto-minhaLocalizacao h1 {
            font-size:1.5em;
            text-align: center;
            color: white;
            background-color: #374B47;
            padding: 5px;
            width:97.5%;
            border-radius:10px;
        }

        .texto-minhaLocalizacao p {
            text-align: justify;
        }

        #map {
            height: 98vh;
            width: 77%;
            border-radius: 20px;
        }

        .legendas {
            background-color: rgb(194, 194, 194);
            padding: 15px;
            border-radius:10px;
        }
        
        .legendas-icones {
            display: flex;
            margin-bottom: 30px;
        }

        .legendas-icones img {
            width: 50px;
        }

        .voltar {
            position: fixed;
            width: 22.5%;
            bottom: 0;
            margin-bottom: 5px;
        }

        .voltar a p {
            font-size:1em;
            text-align: center;
            color: white;
            background-color: #374B47;
            padding: 5px;
            width:97.5%;
            border-radius:10px;
        }

        .voltar a {
            text-decoration: none;
        }

        .voltar a p:hover {
            background-color: #159631;
        }

    </style>
</head>
<body>
    <section class="minhaLocalizacao">
        <section class="texto-minhaLocalizacao">
            <h1>Lugares perto sua localização</h1>
            <p>Encontre lugares perto de você que possam lhe auxiliar na proteção ambiental e no desenvolvimento sustentável.</p>
            <section class="legendas">
                <h4>Legendas:</h4>
                <section class="legendas-icones">
                    <img src="https://img.icons8.com/?size=100&id=7880&format=png&color=DD1C1C" alt="">
                    <p>Localização do usuário</p>
                </section>
                <section class="legendas-icones">
                    <img src="https://img.icons8.com/?size=100&id=7880&format=png&color=3187cc" alt="">
                    <p>Ecopontos</p>
                </section>
                <section class="legendas-icones">
                    <img src="https://img.icons8.com/?size=100&id=7880&format=png&color=28A745" alt="">
                    <p>Orgãos de proteção ambiental</p>
                </section>
            </section>
            <section class="voltar">
                    <a href="index.php">
                        <p>Voltar ao início</p>
                    </a>
                </section>
        </section>
        <section id="map"></section>
        <script src="../../public/js/mapa.js"></script>
    </section>
</body>
</html>
