<?php
require_once __DIR__.'./funcionsBD.php';
$cook = 41245;
echo($cook);
echo nl2br ("\n");
creaUsuari($cook);
$id_ruta = creaRuta($cook,"Minas Ithil",date("Y-m-d H:i:s"),1);
echo($id_ruta);
creaPunt($id_ruta,52.000000, 123.153523,1);
creaPunt($id_ruta,33.000000, 11.000000,2);
creaPunt($id_ruta,42.000000, 72.000000,3);
creaPunt($id_ruta,67.123000, 75.050000,4);
echo nl2br ("\n");
$punts = getPuntsRuta($id_ruta);
foreach ($punts as $punt){
    echo($punt["id_punt"]);
    echo(" ");
    echo($punt["latitud"]);
    echo(" ");
    echo($punt["longitud"]);
    echo(" ");
    echo($punt["ordre_a_ruta"]);
    echo nl2br("\n");
}

?>

<html>
 <head>
  <title>PHP-Test</title>
 </head>
 <body>
  <?php echo '<p>Hello World</p>'; ?>
 </body>
</html>