<?php
require_once ("../require/conexion_class.php");
require_once ("../require/monitoreo_class.php");
require_once ("../require/parametros_class.php");
require_once ("../require/Alerta_class.php");

// GET estacion.waposat.com/Public_html/Template/InsertData3.php?equipo=20&sensor1=2&sensor2=5&sensor3=6&valor1=1&valor2=3&valor3=4
$id_equipo = htmlspecialchars($_GET["equipo"],ENT_QUOTES);

$id_sensor1  = htmlspecialchars($_GET["sensor1"],ENT_QUOTES);
$valor1 = htmlspecialchars($_GET["valor1"],ENT_QUOTES);
$id_sensor2  = htmlspecialchars($_GET["sensor2"],ENT_QUOTES);
$valor2 = htmlspecialchars($_GET["valor2"],ENT_QUOTES);
$id_sensor3  = htmlspecialchars($_GET["sensor3"],ENT_QUOTES);
$valor3 = htmlspecialchars($_GET["valor3"],ENT_QUOTES);

//echo "se han leido los valores";


function verificarRegistrarValor($id_sensor, $id_equipo, $valor){
    $monitoreo = new monitoreo();
    $parametros = new parametros();
    $Alerta = new Alerta();
    $limites = $parametros->ObtenerParametro($id_sensor);
    $LimSup = $limites["LimSup"];
    $LimInf = $limites["LimInf"];

    if($valor > $LimSup){
        $Alerta->registrar($id_equipo, $id_sensor);
    }
    if($valor < $LimInf){
        $Alerta->registrar($id_equipo, $id_sensor);
    }
    $monitoreo->registrar_valor($id_sensor, $id_equipo, $valor);
    
}



//echo "se ha creado el objeto";
verificarRegistrarValor($id_sensor1, $id_equipo, $valor1);
verificarRegistrarValor($id_sensor2, $id_equipo, $valor2);
verificarRegistrarValor($id_sensor3, $id_equipo, $valor3);
echo "se ha finalizado correctamente";
?>