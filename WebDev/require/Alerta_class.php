<?php
//require_once ("../require/conexion_class.php");

class Alerta {
    private $_conexion;
    
    public function __construct(){
        $this->_conexion = new conexion();
    }
    
    public function registrar ($id_equipo, $id_sensor){
        $sql = "insert into Alerta (idAlerta, IdEstacion, IdParametro, DateTime, FlagPantalla, FlagMSM) values (NULL, '".$id_equipo."', '".$id_sensor."', NOW(), '1', '1')";
        $this->_conexion->ejecutar_sentencia($sql);
    }
    
    public function obtenerAlertaPantalla ($id_equipo) {
        $sql = "SELECT * FROM Alerta WHERE IdEstacion='".$id_equipo."' AND FlagPantalla=1 ORDER BY IdAlerta DESC ";
        $this->_conexion->ejecutar_sentencia($sql);
    }
    
    public function BajarFlagAlerta ($IdAlerta){
        $sql = "UPDATE Alerta SET FlagPantalla=0 WHERE IdAlerta='".$IdAlerta."' ";
        $this->_conexion->ejecutar_sentencia($sql);
    }
    
    public function AskAlerta ($IdEstacion){
        $conexion = new conexion();
        $FlajAlerta = 0;
        $this->obtenerAlertaPantalla ($IdEstacion);
        while($alerta = $this->retornar_SELECT()){
            $FlajAlerta = 1;
            $IdAlerta = $alerta["IdAlerta"];
            $sql = "UPDATE Alerta SET FlagPantalla=0 WHERE IdAlerta='".$IdAlerta."' ";
            $conexion->ejecutar_sentencia($sql);
        }
        return $FlajAlerta;
    }
    
    public function retornar_SELECT(){
		return $this->_conexion->retornar_array();
	}
}

?>
