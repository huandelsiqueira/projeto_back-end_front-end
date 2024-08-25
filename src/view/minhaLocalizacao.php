<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locais de Coleta e Reciclagem</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-overpass-layer@3.2.1/dist/OverPassLayer.min.js"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <script>
        // Inicializa o mapa
        var map = L.map('map').setView([-23.5505, -46.6333], 13); // Coordenadas de São Paulo (ajuste conforme necessário)

        // Adiciona o tile layer do OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Consulta Overpass para buscar locais específicos
        var query = `
            [out:json];
            (
              node["amenity"="recycling"];
              node["shop"="florist"];
              node["office"="government"];
            );
            out body;
        `;

        var overpassLayer = new L.OverPassLayer({
            query: query,
            endPoint: "https://overpass-api.de/api/",
            markerIcon: L.icon({
                iconUrl: 'https://unpkg.com/leaflet-overpass-layer@3.2.1/dist/img/recycling.png',
                iconSize: [25, 25]
            }),
            onSuccess: function(data) {
                console.log('Locais carregados com sucesso:', data);
            },
            onError: function(err) {
                console.error('Erro ao carregar os locais:', err);
            }
        });

        map.addLayer(overpassLayer);
    </script>
</body>
</html>
