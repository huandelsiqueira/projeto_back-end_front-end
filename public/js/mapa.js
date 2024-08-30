var map = L.map('map');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var pontosColeta = [
            {"name": "Ecoponto Fragata", "coords": [-31.74600187264455, -52.39384350919012]},
            {"name": "Ecoponto Cerquinha - SANEP", "coords": [-31.761841400845306, -52.34905649847769]},
            {"name": "Ecoponto Centro", "coords": [-31.754026315016013, -52.33110700847719]},
            {"name": "Ecoponto Laranjal", "coords": [-31.769343452149187, -52.23381005766929]}
        ];

        var protecaoAmbiental = [
            {"name": "PATRAM Pelotas - Polícia Ambiental", "coords": [-31.783134027251258, -52.341603896506946]},
            {"name": "Secretaria Municipal de Qualidade Amiental - SMQA", "coords": [-31.755176721320826, -52.319755509173056]}
            
        ];

        var userIcon = L.icon({
            iconUrl: 'https://img.icons8.com/?size=100&id=7880&format=png&color=DD1C1C', // URL da imagem de boneco vermelha
            iconSize: [38, 38], 
            iconAnchor: [22, 38], 
            popupAnchor: [-3, -38] 
        });

        var protecaoIcon = L.icon({
            iconUrl: 'https://img.icons8.com/?size=100&id=7880&format=png&color=28A745', // URL da imagem de boneco verde
            iconSize: [38, 38], 
            iconAnchor: [22, 38], 
            popupAnchor: [-3, -38] 
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLat = position.coords.latitude;
                var userLon = position.coords.longitude;

                map.setView([userLat, userLon], 13);

                pontosColeta.forEach(function(ponto) {
                    L.marker(ponto.coords)
                        .addTo(map)
                        .bindPopup(`<b>${ponto.name}</b>`)
                        .openPopup();
                });

                protecaoAmbiental.forEach(function(ponto) {
                    L.marker(ponto.coords, {icon: protecaoIcon})
                    .addTo(map)
                    .bindPopup(`<b>${ponto.name}</b>`)
                    .openPopup();
                });

                L.marker([userLat, userLon], {icon: userIcon})
                    .addTo(map)
                    .bindPopup("<b>Você está aqui!</b>")
                    .openPopup();

            }, function() {
                alert("Não foi possível obter a sua localização. O mapa será centralizado em Pelotas, RS.");
                map.setView([-31.7654, -52.3371], 13);

                pontosColeta.forEach(function(ponto) {
                    L.marker(ponto.coords)
                        .addTo(map)
                        .bindPopup(`<b>${ponto.name}</b>`)
                        .openPopup();
                });
            });
        } else {
            alert("Geolocalização não é suportada por este navegador.");
            map.setView([-31.7654, -52.3371], 13);

            pontosColeta.forEach(function(ponto) {
                L.marker(ponto.coords)
                    .addTo(map)
                    .bindPopup(`<b>${ponto.name}</b>`)
                    .openPopup();
            });
        }