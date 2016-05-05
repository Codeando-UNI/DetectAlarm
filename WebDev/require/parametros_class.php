<?php
//require_once ("../../require/conexion_class.php");

class parametros {
    private $_conexion;
    
    public function __construct(){
        $this->_conexion = new conexion();
    }
    
    public function ObtenerParametro ($id_parametro){
        $sql = "SELECT * FROM parametros WHERE id_parametro='".$id_parametro."' LIMIT 1";
        $this->_conexion->ejecutar_sentencia($sql);
        return $this->retornar_SELECT();
    }
    
    public function retornar_SELECT(){
		return $this->_conexion->retornar_array();
	}
}

?>
