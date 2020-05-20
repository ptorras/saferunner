$(document).ready(function() {
	$("#route_speed").change(function(){
		console.log("Entrada a la funcio de modificacio");
		var value = $("#route_speed").val();
		var text = "";
		console.log(value);
		switch(value) {
			case "0":
				text = "<h4> Walking speed </h4> <br> <h5> You are expected to run at 6 km/h </h5>";
				console.log("Slow");
			break;

			case "1":
				text = "<h4> Normal speed </h4> <br> <h5> You are expected to run at 10 km/h </h5>";
				console.log("Med");
			break;

			case "2":
				text = "<h4> Madman speed </h4> <br> <h5> You are expected to run at 14 km/h </h5>";
				console.log("Fast");
			break;
		}
		$("#speedcomment").html(text);
	});
});