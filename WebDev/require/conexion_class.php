<?php
class conexion {
	
	private $_conexion;
	private $_base_datos;
	private $_sql;
	private $_result;	
	
	public function __construct () {
		
        // Configuracion AWS EC2
        /*
        $this->_conexion = mysql_connect("localhost", "root", "initec") or die('No pudo conectarse: ' . mysql_error());
	$this->_base_datos = mysql_select_db("DB_waposat");
        */
        
        // Configuracion DigitalOcean WAPOSAT
        
        $this->_conexion = mysql_connect("localhost", "root", "Waposat1_UNI") or die('No pudo conectarse: ' . mysql_error());
	$this->_base_datos = mysql_select_db("DB_waposat");
        
        
        // configuracion para localhost de JOTA I
        /*
        $this->_conexion = mysql_connect("localhost", "root", "jibf123") or die('No pudo conectarse: ' . mysql_error());
	$this->_base_datos = mysql_select_db("DB_waposat");
        */
        
        // configuracion para el servidor
        /*
        $this->_conexion = mysql_connect("localhost", "JIBF", "jibf123") or die('No pudo conectarse: ' . mysql_error());
		$this->_base_datos = mysql_select_db("DB_waposat");
        */
        
        // configuracion para el raspberry
        /*$this->_conexion = mysql_connect("localhost", "root", "teclado") or die('No pudo conectarse: ' . mysql_error());
		$this->_base_datos = mysql_select_db("initec");*/
        
        // Hosting Godaddy
        /*
	$this->_conexion = mysql_connect("localhost", "JIBF", "jibf123") or die('No pudo conectarse: ' . mysql_error());
	$this->_base_datos = mysql_select_db("DB_waposat");
		*/
        
	}
	public function ejecutar_sentencia ($sql) {
		$this->_sql = $sql;
		return ($this->_result = mysql_query($this->_sql , $this->_conexion));
	}
	public function ejecutar_ultima_sentencia () {
		return ($this->_result = mysql_query($this->_sql , $this->_conexion));
	}
	public function retornar_array() {
		return mysql_fetch_array($this->_result);
	}
	public function tam_respuesta() {
		return mysql_num_rows($this->_result);
	}
}
?>
