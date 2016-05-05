<?php
require_once ("../../require/conexion_class.php");
require_once ("../../require/parametros_class.php");
require_once ("../../require/monitoreo_class.php");
$DataTime = array();
$DataValue = array();
$lastID = 0;
$long = 0;
$parametros = new parametros();
$monitoreo = new monitoreo();
$id_parametro = $_POST["id_parametro"];
//$id_parametro = 1;
$id_equipo = $_POST["id_equipo"];
//$id_equipo = 1;
$id_monitoreo = $_POST["lastID"];
//$id_monitoreo = 544;
$monitoreo->mostrar_NewValues($id_parametro, $id_equipo, $id_monitoreo);
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
$arr = array('DataTime' => $DataTime, 'DataValue' => $DataValue, 'lastID' => $lastID, 'long' => $long );
/*
$arr = array('DataTime' => ['12:38', '12:39'], 'DataValue' => [5, 25], 'lastID' => 22, 'long' => 2 );
*/
echo json_encode($arr);
?>