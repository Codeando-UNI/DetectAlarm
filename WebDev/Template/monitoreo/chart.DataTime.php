<?php
require_once ("../../require/conexion_class.php");
require_once ("../../require/parametros_class.php");
require_once ("../../require/monitoreo_class.php");
$DataTime = array();
$DataValue = array();
$lastID = 0;
$long = 0;
$LimSup = 0;
$LimInf = 0;
$size = 20;
$parametros = new parametros();
$monitoreo = new monitoreo();
$id_parametro = $_POST["id_parametro"];
$id_equipo = $_POST["id_equipo"];
$monitoreo->mostrar_valores($id_parametro, $id_equipo, $size);
$ValParametros = $parametros->ObtenerParametro($id_parametro);
$LimSup = $ValParametros["LimSup"];
$LimInf = $ValParametros["LimInf"];
while($valores = $monitoreo->retornar_SELECT()){
    $fechaModificada = substr($valores["fecha"], 8);
    $fechaModificada = "Dia: ".$fechaModificada;
    array_push($DataTime, $fechaModificada);
    array_push($DataValue, $valores["valor"]);
    if($lastID < $valores["id_monitoreo"]){
        $lastID = $valores["id_monitoreo"];
    }
    $long++;
}
$DataTime = array_reverse($DataTime);
$DataValue = array_reverse($DataValue);
$arr = array('DataTime' => $DataTime, 'DataValue' => $DataValue, 'lastID' => $lastID, 'long' => $long, 'LimSup' => $LimSup, 'LimInf' => $LimInf );
/*
$arr = array('DataTime' => ['12:30', '12:31', '12:32', '12:33', '12:34', '12:35', '12:36', '12:37'], 'DataValue' => [0,1,2,3,4,5,6,7], 'lastID' => 20, 'long' => 8, 'LimSup' => 14, 'LimInf' => 0 );
*/
echo json_encode($arr);
?>