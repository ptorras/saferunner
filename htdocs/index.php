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
    <link rel="stylesheet" href="./customstuff.css">
    <title>SafeRunner</title>
    </head>
    <body>
        <div class="container-fluid parallax" >
        	<nav class="navbar navbar-expand-sm navbar-custom fixed-top">
                <div class="container-fluid">
                    <div class = "navbar-header">
                        <a class="navbar-brand" href="./"> <img src="./img/saferunner.png" class = "img-fluid runner-logo"> </a>
                    </div>
                </div>
        	</nav>
            <div class = "container-fluid pagebody" id = "full_container">
                <div class="jumbotron text-center transp-back">
                    <h1> Set your route </h1>
                    <p> Configure your start point, your pace and your time of departure. We'll handle the rest </p>
                </div>

                <div class="container-fluid text-center">
                    <form action="" method="post">
                        <div class="rounded transp-back">
                            <h3> How long will you be running? </h3>
                            From    <input type="time" id="route_time_begin" name="route_time_begin" required>
                            to      <input type="time" id="route_time_end"   name="route_time_end" required>
                        </div>

                        <div class="rounded transp-back">
                            <h3> What's your running speed? </h3>
                            <div class="container slider-container">
                                <input type="range" id="route_speed" name="route_speed" min="0" max="2" value="1" required>
                            </div>
                            <div id="speedcomment" name="speedcomment" class="container-fluid">
                                <h4> Normal speed </h4> <br>
                                <h5> You are expected to run at 9 km/h </h5>
                            </div>
                        </div>
                        <div class="rounded transp-back">
                            <h3> Where are you going to start from? </h3>
                            <div id="map" class="container-fluid"></div>
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
        <script type="text/javascript" src="./scripts/modifiers.js"></script>
        <script type="text/javascript" src="./scripts/map.js"></script>

        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=<?php
                    require_once(__DIR__.'/secret/key.php');
                    echo $key;
                ?>&callback=initMap"> </script>

    </body>
</html>
