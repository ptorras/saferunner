var map;

function beginMap() {
    if (navigator.geolocation)
    {
        console.log("Location");
        navigator.geolocation.getCurrentPosition(function(pos){
            console.log(pos.coords.latitude);
            console.log(pos.coords.longitude);
            initMap(pos.coords.latitude, pos.coords.longitude);
        });
    }
}

function initMap(latitud, longitud) {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat:Number(latitud), lng:Number(longitud)},
        zoom: 15,
    });
}
