<?php 



	require_once('../db/conectadb.php');



	class devoluciones{



		protected $acceso;

 		protected $conexion;



		public function __construct() {

			$this->acceso = new accesoDB(); 

 		 	$this->conexion = $this->acceso->conDB();

   		} 



   		public function datosCount($idClientes,$estado,$fechaInicial,$fechaFinal){

			$datosCount = 0;

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));

			foreach ($idClientes as $idCliente) {

				$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente))));

				$consulta = "SELECT count(*) AS total FROM tblordenesdeservicio c WHERE c.idcliente = '".$idCliente."' AND c.estado = '".$estado."' and ((c.fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and c.fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."')or(c.fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN c.fechaInicial AND c.fechaFinal))";

				$resultado = $this->conexion->query($consulta);

				$filaTmp = $resultado->fetch_assoc();

				$datosCount += $filaTmp["total"];

			}

			return $datosCount;

		}



   		public function listarOrdenes($datos){



			$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['idCliente']))));

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fechaInicial']))));	

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos['fechaFinal']))));		

  			$consulta="SELECT * FROM tblordenesdeservicio WHERE idcliente =".$idCliente." and ((fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."')or(fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN fechaInicial AND fechaFinal)) and (estado ='Autorizada') ";

			$resultado = $this->conexion->query($consulta);

			$datos = array();

			while ($filaTmp = $resultado->fetch_assoc()) {

				$consulta = "SELECT os.idorden,cl.clave_cliente as clave, os.anio,os.fechaInicial, os.fechaFinal,os.norden, os.servicio, osc.idcotconcepto, osc.idpfconcepto, osc.idordconcepto, osc.concepto FROM tblordenesdeservicio os LEFT OUTER JOIN tblordenesconceptos osc ON os.idorden = osc.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.idorden = '".$filaTmp['idorden']."' ";

				$resultadoConceptos = $this->conexion->query($consulta);

				while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {

					$consultaCantidad = "SELECT (osc.cantidad - (SELECT COALESCE(SUM(pfc.cantidad),0) FROM tblprefacturas pf LEFT OUTER JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura WHERE pfc.idordconcepto = osc.idordconcepto AND (pf.estado != 'Cancelada'))) AS cantidad FROM tblordenesconceptos osc WHERE osc.idcotconcepto = '".$filaTmpConcepto['idcotconcepto']."' AND osc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";

					$resultadoCantidad = $this->conexion->query($consultaCantidad);

					$cantidad = $resultadoCantidad->fetch_array();

						if($cantidad["cantidad"] > 0 )

							$datos[] = $filaTmpConcepto;

				}

			}

			if($resultado){

				return $datos;

			}

   			elseif (!$this->conexion->query($consulta)) {

	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";

   			}

			

		}

   		public function guardar($datosPrefactura, $idPfConcepto, $devolucion, $servicio){

   			// var_dump($datosPrefactura);
   			// echo $devolucion;
   			$idPrefactura =  $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosPrefactura['idprefactura']))));
   			$idcliente =  $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosPrefactura['idcliente']))));
   			$clave =  $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datosPrefactura['clave']))));
   			$hoy = date("Y-m-d"); 
   			$año = date("y");
   			$nDevolucion = $this->nDevolucion($clave); 
   			$importe =  $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($devolucion))));
   			$realizo = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($_SESSION["srs_usuario"]))));
   			$servicio = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($servicio))));

  			$idPfConcepto = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPfConcepto))));
  			$devolucion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($devolucion))));

   			// echo $servicio;
  			$consultaPrincipal = "INSERT INTO tblordenesdeservicio (idcliente, anio, fechaInicial, fechaFinal, norden, importe, realizo, servicio,estado, ejecucion, elaboracion ) VALUES('$idcliente','$año','$hoy','$hoy','$nDevolucion','$importe','$realizo','$servicio','Devolucion','noejecutandose','$hoy'); ";

			$resultado = $this->conexion->query($consultaPrincipal);

			if($resultado){
				if($this->conexion->affected_rows === 1){
					$idDevolucion = $this->conexion->insert_id;
					$consulta = "INSERT INTO tblordenesconceptos (idorden, idpfconcepto, idconcepto, concepto, tipoplan, tiposervicio, cantidad, precioUnitario, comision, total,descripcion) (SELECT '$idDevolucion', idprefacturaconcepto, idconcepto, 'Devolución', tipoplan, tiposervicio, '1', '$devolucion', '0.00', '$devolucion','' FROM tblprefacturasconceptos WHERE idprefacturaconcepto = '$idPfConcepto' AND idprefactura = '$idPrefactura'); ";
					// echo $consulta;
					$resultado = $this->conexion->query($consulta);
					if($resultado){
						if($this->conexion->affected_rows === 1){
							return $idDevolucion;
						}
						else
							return "No se insertó el rubro de la devolución.";
					}
					else
						return $this->conexion->errno . " : " . $this->conexion->error . "\n";
				}
				else
					return "No se insertó la devolución.";
			}
			else{
				return $this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
		}



		public function nDevolucion($clave){

			$clave= $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($clave))));	

  			$consulta = "SELECT COALESCE(MAX(o.norden),0) as maxima FROM tblordenesdeservicio o LEFT OUTER JOIN tblclientes cl ON o.idcliente = cl.idclientes WHERE cl.clave_cliente = '".$clave."' AND o.estado like '%Devolucion%' AND o.anio = '".date("y")."'";

			$resultado = $this->conexion->query($consulta);


			if($resultado){
				$datos =  $resultado->fetch_assoc();
				return $datos["maxima"] + 1;
			}
   			else{
	   			echo $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}

		}


		public function __destruct() {

				mysqli_close($this->conexion);

  		}

	}

?>