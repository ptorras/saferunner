console.log("Its loaded");

function initMap() {
    // Funcio de startup de la API de google maps

    // Es crida quan es carrega la API de Google Maps i configura la ubicació 
    // inicial del mapa. En cas que no es pugui fer servir la geolocalització 
    // aleshores es passa una ubicació per defecte

    // Com el pas de la geolocalització només es pot fer via funció de
    // tractament aleshores es crida beginMap, que construeix el mapa, des
    // d'una funció anònima amb les dades de posició.

    console.log("enabled map");
    if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(function(pos){
            beginMap(pos.coords.latitude, pos.coords.longitude);
        });
    }
    else
    {
        beginMap(-25.363, 131.044);
    }
}

function beginMap(latitud, longitud) {
    // Funció que construeix tot el mapa de Google i configura els seus
    // paràmetres (listeners, events, etc)

    // Creació del mapa en si
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat:Number(latitud), lng:Number(longitud)},
        zoom: 15,
    });

    // Crear la finestra informativa per la posició
    var posMark = new google.maps.InfoWindow({
        position: {lat:Number(latitud), lng:Number(longitud)},
        content: "Your Position"
    });

    // Modificar el formulari amb el mapa
    $("#route_in_lat").val(latitud);
    $("#route_in_lng").val(longitud);

    posMark.open(map);

    // En cas de clicks modificar el formulari i la senyal de posició
    map.addListener('click', function(mapsMouseEvent) {
        posMark.close();

        posMark = new google.maps.InfoWindow({
            position: mapsMouseEvent.latLng,
            content: "Your Position"
        });
        posMark.open(map);

        $("#route_in_lat").val(mapsMouseEvent.latLng.lat);
        $("#route_in_lng").val(mapsMouseEvent.latLng.lng);
    });

    // En cas d'enviar el formulari cal recollir-lo i enviar-lo asíncronament
    // amb AJAX (emprant JQuery)
    $("#submitbutton").on("click", function() {
        $("#full_container").hide(500, function() {

            // Trucs javascript per no haver de generar una nova instància del
            // mapa (amaguem el contenidor de resultat, hi movem el mapa
            // anterior i animem de nou l'entrada de l'objecte, eliminant el
            // formulari antic)
            $("#output_container").hide(0);
            var $map_container = $("<div>", {"class": "rounded transp-back"});
            $map_container.append($("#map"));
            $("#output_container").append($map_container);

            // Convertir el formulari a JSON i enviar-ho al cloud
            var formdata = $("#entry_form").serializeArray();
            var json_opt = {};
            for (var elm = 0; elm < formdata.length; elm++)
            {
                json_opt[formdata[elm].name] = formdata[elm].value;
            }

            $("#full_container").remove();

            // Request Post. Internament també s'encarrega de fer la request
            // CORS per a que poguem fer ús de recursos cross origin
            $.post("https://us-central1-carles-voice-recognition.cloudfunctions.net/safe-runner-path",
                json_opt, function(data, status) {
                console.log("Gotten data");
                console.log(data);

                data = data.replace(/'/g, '"');
                var coords = JSON.parse(data);
                console.log(coords);

                // Calculem un nou punt central on moure el mapa
                var tot_lng = 0.0;
                var tot_lat = 0.0;

               	for (var x = 0; x < coords.length; x++)
                {
                	console.log(coords[x]);
                    tot_lng += coords[x].lng;
                    tot_lat += coords[x].lat;
                }

                console.log(tot_lng);
                console.log(tot_lat);

                // Per evitar problemes de divisions per zero
                tot_lng /= coords.length > 0.0? coords.length: 1.0;
                tot_lat /= coords.length > 0.0? coords.length: 1.0;

                const center = new google.maps.LatLng(tot_lat, tot_lng);
                map.panTo(center);

                var test_line = new google.maps.Polyline({
                    path: coords,
                    geodesic: false,
                    strokeColor: '#f542e3',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
            	});
		    	console.log(test_line);
                test_line.setMap(map);
            });

            // Detall per posar la càmara de nou a la part de dalt de la
            // pàgina
            $("#output_container").show(500, function() {
                $("html, body").animate({scrollTop: 0}, 1000, "swing", function() {
                    
                });
            });
        });
    });
}
