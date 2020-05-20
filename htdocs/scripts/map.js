var map;

function getLocation() {
	if (navigator.geolocation)
	{
		var position = {
			lat: position.coords.latitude,
			long: position.coords.longitude
		};
		return position;
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

	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
		center: myLatLng
	});
}