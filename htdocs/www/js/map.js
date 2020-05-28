console.log("Its loaded");
// Funcio de startup de la API de google maps

function initMap() {
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
    // El mapa en si
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

    // En cas de clicks modificar el formulari i la senyal
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

    $("#submitbutton").on("click", function() {
        $("#full_container").hide(500, function() {
            $("#output_container").hide(0);
            var $map_container = $("<div>", {"class": "rounded transp-back"});
            // Afegir titol i altres histories per indicar la ruta
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

            //$.post("https://us-central1-safe-runner.cloudfunctions.net/function-2",
            $.post("https://us-central1-carles-voice-recognition.cloudfunctions.net/safe-runner-path",
                json_opt, function(data, status)
                {
                    console.log("Gotten data");
                    console.log(data);

                    data = data.replace(/'/g, '"');
                    var coords = JSON.parse(data);
                    console.log(coords);		    
 		    
		    var gcoord = [new google.maps.LatLng(data[0][lat], data[0][lng])];
		    for (var x = 1; x < data.lenght; x++)
		    {
			gcoord.push(new google.maps.LatLng(data[x][lat], data[x][lng]));
		    }
			
                    // var tot_lng = 0.0;
                    // var tot_lat = 0.0;

                    // for (var x = 0; x < data.length; x++)
                    // {
                    //     console.log(typeof(data[x].lng));
                    //     tot_lng += data[x].lng;
                    //     tot_lat += data[x].lat;
                    // }

                    // console.log(tot_lng);
                    // console.log(tot_lat);
                    // tot_lng /= data.length > 0.0? data.length: 1.0;
                    // tot_lat /= data.length > 0.0? data.length: 1.0;

                    // const center = new google.maps.LatLng(tot_lat, tot_lng);
                    // map.panTo(center);

                    var test_line = new google.maps.Polyline({
                        path: gcoord,
                        geodesic: false,
                        strokeColor: '#f542e3',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });
		    console.log(test_line);

                    test_line.setMap(map);
                });

            $("#output_container").show(500, function() {
                $("html, body").animate({scrollTop: 0}, 1000, "swing", function() {
                    
                });
            });
        });
    });
}
