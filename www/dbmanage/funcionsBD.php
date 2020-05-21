<?php
require_once __DIR__.'./connectaBD.php';

function creaUsuari($id_cookie){
    $connexio = connectaBD();
    $sql = $connexio->prepare("INSERT INTO `usuari` (`id_cookie`) VALUES (:cookie);");
    $sql->bindParam(':cookie', $id_cookie);
    $sql->execute();
}

// Ara mateix afegir punts i crear la ruta ho tinc en funcions separades,
// també es podria fer un una sola que tingués per parametres el mateix
// que creaRuta més una llista amb la info dels punts. Si us ha de ser
// més còmode així, m'ho dieu i les fusiono.

// Assumeix que existeix un usuari amb id id_cookie
// data en format DATETIME, des de php date("Y-m-d H:i:s"). Per default calcula l'actual
// municipi és un string i ritme és un enter ( 1, 2, 3 ...)
// retorna la id de la ruta creada, per poder-hi afegir els punts
function creaRuta($id_cookie,$municipi,$data,$ritme){
    /*
    $municipi = filter_var($municipi, FILTER_SANITIZE_STRING);
    if (!(filter_data($ritme, FILTER_VALIDATE_INT))) throw new Exception("Unsafe data entry");
    */

    $connexio = connectaBD();
    $sql = $connexio->prepare("INSERT INTO `ruta` (`id`, `id_cookie`, `municipi`, `data`, `ritme`) VALUES (NULL, :Cookie, :Municipi, :Data, :Ritme);");
    $sql->bindParam(':Cookie', $id_cookie);
    $sql->bindParam(':Municipi', $municipi);
    $sql->bindParam(':Data', $data);
    $sql->bindParam(':Ritme', $ritme);
    $sql->execute();
    $id_ruta = $connexio->lastInsertId();
    return $id_ruta;
}

// Again, assumeix que existeix la ruta id_ruta
// lat i long son floats de la mida recomanada per google (4 dec abans de la coma 6 després)
function creaPunt($id_ruta,$lat,$long,$ordre){
    /*
    if (!(filter_data($lat, FILTER_VALIDATE_FLOAT) and filter_data($long, FILTER_VALIDATE_FLOAT) and filter_data($ordre, FILTER_VALIDATE_INT))) throw new Exception("Unsafe data entry");
    */
    $connexio = connectaBD();
    $sql = $connexio->prepare("INSERT INTO `punt` (`id_ruta`, `latitud`, `longitud`, `ordre_a_ruta`) VALUES (:id_ruta, :lat, :long, :ord);");
    $sql->bindParam(':id_ruta', $id_ruta);
    $sql->bindParam(':lat', $lat);
    $sql->bindParam(':long', $long);
    $sql->bindParam(':ord', $ordre);
    $sql->execute();
}

// TODO: function getPuntsRuta($id_ruta)
function getPuntsRuta($id_ruta){
    $connexio = ConnectaBD();
    $sql = $connexio->prepare('SELECT * FROM `punt` WHERE `id_ruta` = :id');
    $sql->bindParam(':id', $id_ruta);
    $sql->execute();
    $punts = [];
    while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
        //$prods[] = $result;
        $punts += [$result["id_punt"] => $result ];
        //consol.log($result);
    }
    //print_r($prods);
    return $punts;
}

