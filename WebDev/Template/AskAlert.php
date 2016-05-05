<?php
require_once ("../require/conexion_class.php");
require_once ("../require/Alerta_class.php");

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