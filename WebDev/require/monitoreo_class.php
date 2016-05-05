<?php
//require_once ("../require/conexion_class.php");

class monitoreo {
    private $_conexion;
    
    public function __construct(){
        $this->_conexion = new conexion();
    }
    
    public function registrar_valor ($id_sensor, $id_equipo, $valor){
        $sql = "insert into monitoreo (id_monitoreo, id_sensor, id_equipo, fecha, valor) values (NULL, '".$id_sensor."', '".$id_equipo."', NOW(), '".$valor."')";
        $this->_conexion->ejecutar_sentencia($sql);
    }
    
    public function mostrar_valores ($id_sensor, $id_equipo, $size) {
        $sql = "SELECT * FROM monitoreo WHERE id_sensor='".$id_sensor."' AND id_equipo='".$id_equipo."' ORDER BY id_monitoreo DESC LIMIT 0 , ".$size." ";
        $this->_conexion->ejecutar_sentencia($sql);
    }
    
    public function mostrar_NewValues($id_sensor, $id_equipo, $lastID){
        $sql = "SELECT * FROM monitoreo WHERE id_sensor='".$id_sensor."' AND id_equipo='".$id_equipo."' AND id_monitoreo>".$lastID." ORDER BY id_monitoreo DESC";
        $this->_conexion->ejecutar_sentencia($sql);
    }
    
    public function retornar_SELECT(){
		return $this->_conexion->retornar_array();
	}
}

?>
