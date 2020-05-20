var map;

function getLocation() {
    if (navigator.geolocation)
    {
        var location;
        console.log("Location");
        navigator.geolocation.getCurrentPosition(function(pos){
            console.log("Got the Location");
            location = {
                lat: pos.coords.latitude,
                lat: pos.coords.longitude
            }
        });
        return location;
    }
    else
    {
        return 0;
    }

}

function initMap() {
    var myLatLng = {lat:41.55, long:2.225};
    var loc = getLocation();

    if (loc != 0)
    {
        myLatLng = loc;
    }

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: myLatLng
    });
}