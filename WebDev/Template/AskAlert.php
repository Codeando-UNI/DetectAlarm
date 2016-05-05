<?php
require_once ("../require/conexion_class.php");
require_once ("../require/Alerta_class.php");

// URL
// GET estacion.waposat.com/Public_html/Template/AskAlert.php?equipo=20

$id_equipo = htmlspecialchars($_GET["equipo"],ENT_QUOTES);

//echo "se han leido los valores";
$Alerta = new Alerta();
//echo "se ha creado el objeto";
$EstadoAlerta = $Alerta->AskAlerta($id_equipo);

if ($EstadoAlerta == 1){
    echo "ALERT";
} else {
    echo "OK";
}

?>