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
$size = $_POST["size"];

$monitoreo->mostrar_NewValues($id_parametro, $id_equipo, $id_monitoreo);

while($valores = $monitoreo->retornar_SELECT()){
    $datetmp = strtotime($valores["fecha"]);
    $horatmp = date('H',$datetmp)-1;
    $minutotmp = date('i',$datetmp);
    $segundotmp = date('s',$datetmp);
    $fechaModificada = $horatmp.":".$minutotmp.":".$segundotmp;
    $fechaModificada = "".$fechaModificada;
    array_push($DataTime, $fechaModificada);
    array_push($DataValue, $valores["valor"]);
    if($lastID < $valores["id_monitoreo"]){
        $lastID = $valores["id_monitoreo"];
    }
    $long++;
}

$DataTime = array_reverse($DataTime);
$DataValue = array_reverse($DataValue);

// Revisando historial de data

$monitoreo->mostrar_valores($id_parametro, $id_equipo, $size);
$ValParametros = $parametros->ObtenerParametro($id_parametro);

$months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

$LimSup = $ValParametros["LimSup"];
$LimInf = $ValParametros["LimInf"];

$firstVal = 0;
$lastVal = 0;
$AcumVal = 0;
$lastIDTotal = 0;

$longTotal = 0;

while($valores = $monitoreo->retornar_SELECT()){
    if ($longTotal == 0){
        $valMax = $valores["valor"];
        $valMin = $valores["valor"];
    }
    if ($valMax < $valores["valor"]){
        $valMax = $valores["valor"];
    }
    if ($valMin > $valores["valor"]){
        $valMin = $valores["valor"];
    }
    $firstVal = $valores["valor"];
    $AcumVal = $AcumVal+$valores["valor"];
    if($lastIDTotal < $valores["id_monitoreo"]){
        $lastIDTotal = $valores["id_monitoreo"];
        $lastVal = $valores["valor"];
        $date = $valores["fecha"];
    }
    $longTotal++;
}

//Trabajando con la ultima fecha
$date = strtotime($date);
$mesText = $months[date('n', $date)-1];
$dia = date('d', $date);
$hora = date('H', $date)-1;
$fechaText = "Dia: ".$mesText."-".$dia." ".$hora."horas";


$TiempoMuestraBtn = $longTotal." puntos";
$limitesText = "Limites: ".$LimInf."-".$LimSup;
$unidMedida = ""; //Superior e Inferior
$valVar = $lastVal - $firstVal;
$valVar = round($valVar,3);
$valVarx100 = ($valVar*100)/$lastVal;
$valVarx100 = round($valVarx100,2);
$valVarx100Text = $valVarx100."%";
if($valVar > 0){
    $varArrow = 1;
} else {
    $varArrow = 0;
}

$valFinal = $lastVal;
$valIni = $firstVal;
if($valFinal > $LimSup or $valFinal < $LimInf){
    $valFace = 1;
} else {
    $valFace = 0;
}

$valMedio = $AcumVal/$longTotal;
$valMedio = round($valMedio,2);



$arr = array('DataTime' => $DataTime, 'DataValue' => $DataValue, 'lastID' => $lastID, 'fechaText' => $fechaText, 'TiempoMuestraBtn' => $TiempoMuestraBtn, 'limitesText' => $limitesText, 'unidMedida' => $unidMedida, 'varArrow' => $varArrow, 'valVar' => $valVar, 'valVarx100' => $valVarx100Text, 'valFinal' => $valFinal, 'valIni' => $valIni, 'valFace' => $valFace, 'valMax' => $valMax, 'valMin' => $valMin, 'valMedio' => $valMedio, 'long' => $long, 'varLimSup' => $LimSup, 'varLimInf' => $LimInf, 'longTotal' => $longTotal );
/*
$arr = array('DataTime' => ['12:38', '12:39'], 'DataValue' => [5, 25], 'lastID' => 22, 'long' => 2 );
*/
echo json_encode($arr);
?>