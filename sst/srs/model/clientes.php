<?php 

	require_once('../db/conectadb.php');

	class clientes{

		protected $acceso;
 		protected $conexion;

		public function __construct() {
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = $this->acceso->conDB();
   		} 
		
		public function listarClientes($usuario){

			require_once('usuarios.php');
			$usuarios = new usuarios();
			$usuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($usuario))));
			$resultado = $usuarios -> datosUsuario($usuario);
			if(is_array($resultado) && count($resultado) == 1)
			{
				$resultado = $this->datosCliente($resultado);
				return $resultado;
			}
			else
				return $resultado;
			
		}

		public function datosCliente($idUsuario){

			$idUsuario = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idUsuario['idusuarios']))));
  			$consulta="SELECT idclientes,rfc,concat(razon_soc,' | ',rfc,' | ',nom_comercial) AS cliente, clave_cliente FROM tblclientes WHERE idclientes IN (SELECT idcliente FROM tblusuariosclientes WHERE idusuario = ".$idUsuario.") order by razon_soc";
			$resultado = $this->conexion->query($consulta);
			$datos = array();
			while ($filaTmp = $resultado->fetch_assoc()) {
				$datos[] = $filaTmp;
			}
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function razonSocial($idCliente){

			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
			$consulta = "SELECT razon_soc FROM tblclientes WHERE idclientes = '".$idCliente."'";
  			$resultado = $this->conexion->query($consulta);
			$datos = $resultado->fetch_assoc();
  			
			if($resultado){
				return $datos["razon_soc"];
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function datosClienteEspecifico($idCliente){

			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));	
  			$consulta="SELECT clave_cliente FROM tblclientes WHERE idclientes = '".$idCliente."'";
			$resultado = $this->conexion->query($consulta);
			$datos = $resultado->fetch_assoc();
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function cargarClientes(){

  			$consulta="SELECT idclientes,clave_cliente, razon_soc as cliente FROM tblclientes";
			$resultado = $this->conexion->query($consulta);
			while($filaTmp = $resultado->fetch_assoc()){ 
				$datos[] = $filaTmp;
			}
			if($resultado){
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
		}

		public function __destruct() {
				mysqli_close($this->conexion);
  		}
	}
?>