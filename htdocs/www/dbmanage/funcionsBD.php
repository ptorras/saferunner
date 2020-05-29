<!-- THIS PROGRAM IS UNUSED AS ALL CONNECTIONS ARE DONE THROUGH PYHON, BUT IT WORKS -->

<?php
require_once __DIR__.'/connectaBD.php';

function creaRuta($municipi,$data,$ritme, $punts){
    /*
    Function that inserts a new route to the database and all of it's children points.
    param municipi: town of the route to be created
    param data: date and time of the route to be created
    param ritme: pace of the user's walking
    param punts: list of dictionaries with the information that needs to be stored from each points
    return: id of the newly created route
    */

    $connexio = connectaBD();
    $sql = $connexio->prepare("INSERT INTO `ruta` (`municipi`, `data`, `ritme`) VALUES (:Municipi, :Data, :Ritme);");
    $sql->bindParam(':Municipi', $municipi);
    $sql->bindParam(':Data', $data);
    $sql->bindParam(':Ritme', $ritme);
    $sql->execute();
    $id_ruta = $connexio->lastInsertId();
    
    foreach ($punts as $punt) {
        $connexio = connectaBD();
        $sql = $connexio->prepare("INSERT INTO punt (`id_ruta`,`id_waypoint`,`nom_waypoint`,`data`,`latitud`, `longitud`, `ordre_a_ruta`) VALUES (:id_ruta,:id_waypoint,:nom_waypoint,:Data,:latitud, :longitud, :ordre_a_ruta);");
        //:id_ruta,:id_waypoint,:nom_waypoint,:Data,:latitud, :longitud, :ordre_a_ruta
        $sql->bindParam(':id_ruta', $id_ruta);
        $sql->bindParam(':id_waypoint', $punt["id_waypoint"]);
        $sql->bindParam(':nom_waypoint', $punt["nom_waypoint"]);
        $sql->bindParam(':Data', $punt["data"]);
        $sql->bindParam(':latitud', $punt["latitud"]);
        $sql->bindParam(':longitud', $punt["longitud"]);
        $sql->bindParam(':ordre_a_ruta', $punt["ordre"]);
        $sql->execute();
    }
    return $id_ruta;
}

function creaPunt($id_ruta,$lat,$long,$ordre){
    /*
    -------- can't be used with the current database --------
    Function that inserts a new point to the database, given its information.
    param id_ruta: id of the point's parent route
    param lat: latitude of the point
    param lat: latitude of the point
    param ordre: order of the point inside the route
    */
    $connexio = connectaBD();
    $sql = $connexio->prepare("INSERT INTO `punt` (`id_ruta`, `latitud`, `longitud`, `ordre_a_ruta`) VALUES (:id_ruta, :lat, :long, :ord);");
    $sql->bindParam(':id_ruta', $id_ruta);
    $sql->bindParam(':lat', $lat);
    $sql->bindParam(':long', $long);
    $sql->bindParam(':ord', $ordre);
    $sql->execute();
}

function getPuntsRuta($id_ruta){
    /*
    Function to get all points from a route
    param id_ruta: id of the route to be retrieved
    return: list of dictionaries containing all information from each point
    */
    $connexio = ConnectaBD();
    $sql = $connexio->prepare('SELECT * FROM `punt` WHERE `id_ruta` = :id');
    $sql->bindParam(':id', $id_ruta);
    $sql->execute();
    $punts = [];
    while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
        $punts += [$result["id_punt"] => $result ];
    }
    return $punts;
}

