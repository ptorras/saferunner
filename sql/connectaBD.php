<?php
    function connectaBD(){
        $servidor = "localhost";
        $usuari = "root";
        $clau = "";
        $nomBD = "saferunner";
        try{
            $connexio = new PDO("mysql:host=$servidor;dbname=$nomBD;charset=UTF8", $usuari, $clau);
            $connexio->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //obliga a llançar excepcions
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        return($connexio);
    }