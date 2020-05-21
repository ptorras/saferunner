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
}

function startScript(){
    console.log("Starting python script");
    $.ajax({
        url: "src/maps.py",
        type: "POST",
        timeout: 60000,
        async: true,
        data: {"url": dominio, "tema": tematica},
        success: function (response) {
            console.log("OK");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
    });
}
