function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            var map = new google.maps.Map(document.getElementById('map'), {
                center: userLocation,
                zoom: 14
            });

            var marker = new google.maps.Marker({
                position: userLocation,
                map: map,
                title: 'Sua localização'
            });

            var request = {
                location: userLocation,
                radius: '5000',
                type: ['recycling_center', 'florist', 'local_government_office']
            };

            var service = new google.maps.places.PlacesService(map);
            service.nearbySearch(request, function(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    for (var i = 0; i < results.length; i++) {
                        var place = results[i];
                        createMarker(place);
                    }
                }
            });

            function createMarker(place) {
                var placeLoc = place.geometry.location;
                var marker = new google.maps.Marker({
                    map: map,
                    position: placeLoc
                });

                google.maps.event.addListener(marker, 'click', function() {
                    var infoWindow = new google.maps.InfoWindow();
                    infoWindow.setContent(place.name);
                    infoWindow.open(map, this);
                });
            }

        }, function() {
            handleLocationError(true, map.getCenter());
        });
    } else {
        handleLocationError(false, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, pos) {
    alert(browserHasGeolocation ?
          'Erro: O serviço de Geolocation falhou.' :
          'Erro: Seu navegador não suporta Geolocation.');
}
