<?php
//require_once ("../require/conexion_class.php");

class RelacionEquipo {
    private $_conexion;
    
    public function __construct(){
        $this->_conexion = new conexion();
    }
    
    public function mostrar_valores ($id_equipo) {
        $sql = "SELECT * FROM RelacionEquipo WHERE id_equipo=".$id_equipo." ORDER BY id_parametro ASC ";
        $this->_conexion->ejecutar_sentencia($sql);
    }
    
    public function retornar_SELECT(){
		return $this->_conexion->retornar_array();
	}
}

?>
