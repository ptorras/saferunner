<!doctype html>
<html lang="en">
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
                            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
                            crossorigin="anonymous">
    <link rel="stylesheet" href="www/css/style.css">
    <title>SafeRunner</title>
    </head>
    <body>
        <div class="container-fluid parallax" >
        	<nav class="navbar navbar-expand-sm navbar-custom fixed-top">
                <div class="container-fluid">
                    <div class = "navbar-header">
                        <a class="navbar-brand" href="./"> <img src="./www/images/saferunner.png" class = "img-fluid runner-logo"> </a>
                    </div>
                </div>
        	</nav>
            <div class="container-fluid pagebody" id = "full_container">
                <div class="jumbotron text-center transp-back">
                    <h1> Set your route </h1>
                    <p> Configure your start point, your pace and your time of departure. We'll handle the rest </p>
                </div>

                <div class="container-fluid text-center">
                    <form id="route_form"> <!-- method="post"> -->
                        <div class="rounded transp-back">
                            <h3> How long will you be running? </h3>
                            From    <input type="time" id="route_time_begin" name="route_time_begin" required>
                            to      <input type="time" id="route_time_end"   name="route_time_end" required>
                            of day  <input type="date" id="route_time_date"  name="route_time_date" required>
                        </div>

                        <div class="rounded transp-back">
                            <h3> What's your running speed? </h3>
                            <div class="container slider-container">
                                <input type="range" id="route_speed" name="route_speed" min="0" max="2" value="1" required>
                            </div>
                            <div id="speedcomment" name="speedcomment" class="container-fluid">
                                <h4> Normal speed </h4> <br>
                                <h5> You are expected to run at 10 km/h </h5>
                            </div>
                        </div>
                        <div class="rounded transp-back">
                            <h3> Where are you going to start from? </h3>
                            Click on the map to get your initial position.
                            <div id="map" class="container-fluid"></div>
                            <h5> Your coordinates are: </h5>
                            Latitude  <input type="number" id="route_in_lat" name="route_lat" readonly>
                            Longitude <input type="number" id="route_in_lng" name="route_lng" readonly>
                        </div>
                        <div class="rounded transp-back">
                            <input class="submit-it" type="button" value="Make a route" onclick="startScript()">
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <footer class="footer fixed-bottom footer-custom">
            <div class="container">
                <div>
                    ©2020 SafeRunner Project. Background image by <a href="https://commons.wikimedia.org/wiki/File:Fisher_Run_Road_2.JPG" title="via Wikimedia Commons">Jakec</a> / <a href="https://creativecommons.org/licenses/by-sa/4.0">CC BY-SA</a>
                </div>
            </div>
        </footer>

    	<!-- Optional JavaScript -->
    	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
    	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
                integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
                crossorigin="anonymous"></script>
        <!-- Scripts per fer la ruta -->

        <!-- Scripts per a la pagina -->
        <script async defer type="text/javascript" src="www/js/modifiers.js"></script>
        <script async defer type="text/javascript" src="www/js/map.js"></script>

        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=<?php
                echo $MAPS_API_KEY;
                ?>&callback=initMap"> </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </body>
</html>
