<?php 
class clientesCompras
	{
 		protected $conexion;

		public function __construct() 
		{ 
 		 	$this->conexion = accesoDB::conDB();
   		}	

   		public function rubrosCliente($idCliente){
			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));
   			$datos = array();
   			$consulta="SELECT nombre, 'Producto' AS tipo FROM spartodo_compras.tblProductosClientes pc LEFT JOIN spartodo_compras.tblProductos p ON pc.idProducto = p.idProducto WHERE idCliente = '$idCliente' UNION SELECT nombre, 'Servicio' AS tipo FROM spartodo_compras.tblServiciosClientes LEFT JOIN spartodo_compras.tblServicios s ON s.idServicio = s.idServicio WHERE idCliente = '$idCliente'";
			// echo $consulta;
			$resultado = $this->conexion->query($consulta);
			
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos [] = $filaTmp;
				}
				return $datos;
			}
   			else{
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
   		}
   		
   }
?>