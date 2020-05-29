<!-- THIS PROGRAM IS UNUSED AS ALL CONNECTIONS ARE DONE THROUGH PYHON, BUT IT WORKS -->

<?php
    function connectaBD(){
        /* 
        Function that connects to the database hardcoded on its variables
        return: PDO connection that is later used in FuncionsDB to interact with the database
        */
        // Insert in this three variables your database information
        $usuari = "root"; // username
        $clau = "HackSM"; // password for that username, leave "" if none
        $nomBD = "saferunnerDB"; // name of the database table
        
        // set $servidor=localhost if hosting the sql database locally
        
        // Follow google cloud's documentation to know where to find the connection name for your sql instance
        // If you repeat our steps its [PROJECT_ID]:[HOSTING_SERVER_LOCATION]:[CLOUD_SQL_INSTANCE_NAME]
        $cloud_sql_connection_name = "balmy-virtue-277911:europe-west3:saferunner-sql"; 
        try{
            // use the below line instead of the rest of the try clause if you're using a local SQL server
            //$connexio = new PDO("mysql:host=$servidor;dbname=$nomBD;charset=UTF8", $usuari, $clau);
            $dsn = sprintf( 'mysql:dbname=%s;unix_socket=/cloudsql/%s',
                $nomBD,
                $cloud_sql_connection_name
            );
            $connexio = new PDO($dsn, $usuari, $clau, [
                PDO::ATTR_TIMEOUT => 5,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        echo "connexio correcta";
        return($connexio);
    }
