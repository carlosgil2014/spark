<?php 
/**
* clase abstracta que nos permite conectarnos a mysql
*/
abstract class Model
{
	//atributos
	// privados y estatico 
	private static $db_Host = 'localhost';
	private static $db_root = 'root';
	private static $db_pass = 'ST0SP4R15';
	//private static protected $db_name = metfilx si es para aplicacion sencilla
	protected $db_name ;
	private static $db_charset = 'utf8';
	private $conn;
	protected $query;
	protected $rows = array();

	//metodo privado para conectarse a bd
	private function db_open(){
		$this->conn = new mysqli(self::$db_Host,self::$db_root,self::$db_pass,$this->db_name);
		$this->conn->set_charset(self::$db_charset);
	}

	private function db_close(){
		$this->conn->close();
	}

	//establecer un query simple que afecte datos de tipo insert , delete , update
	protected function set_query(){
	$this->db_open();
	//metodo query heredado de mysqli
	$this->conn->query($this->query);
	$this->db_close();
	}

	//obtener resultados de una consulta tipo select en un array
	protected function get_query(){
		$this->db_open();
		$result = $this->conn->query($this->query);
		while( $this->rows[] = $result->fetch_assoc() );
		$result->close();
		$this->db_close();
		return array_pop($this->rows);
	}
}
 ?>