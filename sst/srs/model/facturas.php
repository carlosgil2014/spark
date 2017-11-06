<?php 

	require_once('../db/conectadb.php');

	class factura{

		protected $acceso;
 		protected $conexion;

		public function __construct() 
		{
			$this->acceso = new accesoDB(); 
 		 	$this->conexion = $this->acceso->conDB();
   		}

   		public function facturaEspecifica($idFacturaEspecifica)
		{
			$idFacturaEspecifica = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idFacturaEspecifica))));
			$consulta = "SELECT p.detalle,p.realizo,p.fechaInicial,p.importe,p.anio,p.nprefactura,p.estado,p.tipo,p.edopago,p.descuento,p.motivodescuento,p.motivocancelacion,p.cfdi,cl.clave_cliente as clave FROM tblprefacturas p LEFT OUTER JOIN tblclientes cl ON p.idcliente = cl.idclientes WHERE idprefactura=".$idFacturaEspecifica;
			$resultado = $this->conexion->query($consulta);
			if($resultado)
				$datos = $resultado->fetch_assoc();
			elseif (!$this->conexion->query($consulta))
	   			$datos = $this->conexion->errno . " : " . $this->conexion->error . "\n";

	   		return $datos;

		}
		// public function listarConceptosFactura($idFactura)
		// {
		// 	$idFactura = $this->conexion->real_escape_string(strip_tags(stripslashes(trim($idFactura))));
		// 	$consulta = "SELECT * FROM tblprefacturasconceptos WHERE idprefactura=".$idFactura;
		// 	$resultado = $this->conexion->query($consulta);
		// 	if($resultado)
		// 	{
		// 		while($datosFactura=$resultado->fetch_assoc())
		// 		$datos[] = $datosFactura;
		// 	}
		// 	elseif (!$this->conexion->query($consulta))
	 //   			$datos = $this->conexion->errno . " : " . $this->conexion->error . "\n";

	 //   		return $datos;
		// }
		public function sumaConceptosFactura($idFactura)
		{
			$idFactura=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idFactura))));
			$consulta="SELECT SUM(cantidad*precioUnitario) AS totalPu, SUM((cantidad*precioUnitario)*(comision/100)) AS totalCa, SUM(total) AS totalT FROM tblprefacturasconceptos WHERE idprefactura = ".$idFactura;
			$resultado=$this->conexion->query($consulta);
			if($resultado)
				$datos=$resultado->fetch_assoc();
			elseif (!$this->conexion->query($consulta)) {
				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
			return $datos;
		}
		public function pagosRealizados($idFactura)
		{
			$idFactura=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idFactura))));
			$consulta="SELECT SUM(pago) AS pagoTotal FROM tblpago WHERE idprefactura = ".$idFactura;
			$resultado=$this->conexion->query($consulta);
			if($resultado)
				$datos=$resultado->fetch_assoc();
			elseif (!$this->conexion->query($consulta)) {
				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
			return $datos;
		}
		public function cancelarFactura($datos)
		{	

			$idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idPf"]))));
			$edoPago = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["edoPago"]))));
			$motivoCancelacion = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["motivoCancelacion"]))));

			$consulta = "UPDATE tblprefacturas SET estado = '".$edoPago."', motivocancelacion='".$motivoCancelacion."' WHERE idprefactura=".$idPrefactura;
			$resultado=$this->conexion->query($consulta);
			if($resultado)
			{
				if(count($datos["idOrden"]) > 0 && is_array($datos["idOrden"]))
				{
					$idOrdenes = implode(",",$datos["idOrden"]);
					$consulta = "UPDATE tblordenesdeservicio SET estado = 'Cancelada', motivo = '".$motivoCancelacion."' WHERE idorden IN(".$idOrdenes.")";
					$resultado = $this->conexion->query($consulta);
					if($resultado)
						$datos = true;
					else
						$datos = false;
				}
				$datos = true;
			}
			elseif (!$this->conexion->query($consulta)) {
				$datos=false;
			}
			return $datos;

		}
		public function facturanoPagada($datos)
		{
			$idPrefactura=$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idPf"]))));
			$consulta="UPDATE tblprefacturas SET estado = 'Facturada', edopago='nopagado', motivocancelacion='' WHERE idprefactura=".$idPrefactura;
			$resultado=$this->conexion->query($consulta);
			if($resultado)
				$datos=true;
			elseif (!$this->conexion->query($consulta)) {
				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
			return $datos;

		}
		public function pagos($datos)
		{
			$idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["idPf"]))));
			$edoPago = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["edoPago"]))));
			$fechaPago = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["fechaPago"]))));
			$pago =	$this->conexion -> real_escape_string(strip_tags(stripslashes(trim($datos["pagoPf"]))));

			$consulta1="INSERT INTO tblpago(idprefactura,fechapago,pago) values (".$idPrefactura.",'".$fechaPago."','".$pago."')";
			$consulta2="UPDATE tblprefacturas SET estado = 'Facturada', edopago='".$edoPago."', motivocancelacion='' WHERE idprefactura=".$idPrefactura;
			$resultado1=$this->conexion->query($consulta1);
			$resultado2=$this->conexion->query($consulta2);
			if($resultado1 && $resultado2)
				$datos=true;
			elseif (!$this->conexion->query($consulta1)) {
				$datos=$this->conexion->errno . " : " . $this->conexion->error . "\n";
			}
			return $datos;

		}
		public function listarConceptosFactura($idPrefactura){

			$idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idPrefactura))));	
  			$consulta="SELECT pfc.idprefacturaconcepto,pfc.idcotconcepto,pfc.idordconcepto,pfc.cantidad, pfc.concepto, pfc.tipoplan, pfc.tiposervicio,cc.descrip AS descripcion,pfc.precioUnitario as precio, pfc.comision,pfc.total,cl.clave_cliente,c.anio AS anioCot,os.anio AS anioOs,c.ncotizacion,os.norden FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblordenesconceptos osc ON pfc.idordconcepto = osc.idordconcepto LEFT OUTER JOIN tblcotizacionconceptos cc ON pfc.idcotconcepto = cc.idcotconcepto OR osc.idcotconcepto = cc.idcotconcepto LEFT OUTER JOIN tblcotizaciones c ON cc.idcotizacion = c.id LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden  LEFT OUTER JOIN tblclientes  cl ON cl.idclientes = os.idcliente OR cl.idclientes = c.idcliente WHERE pfc.idprefactura = '".$idPrefactura."'";
			$resultado = $this->conexion->query($consulta);
			if($resultado){
				while ($filaTmp = $resultado->fetch_assoc()) {
					$datos[] = $filaTmp;  
				}
				return $datos;
			}
   			elseif (!$this->conexion->query($consulta)) {
	   			return $this->conexion->errno . " : " . $this->conexion->error . "\n";
   			}
			
		}
		public function ordenesExistentes($datos)
		{
			$datosOs = array();
			$idPrefactura = $this->conexion-> real_escape_string(strip_tags(stripslashes(trim($datos["idPf"]))));
			$consulta = "SELECT COALESCE(IFNULL(COUNT(DISTINCT idcotizacion),0),0) AS numCotizacion FROM `tblprefacturasconceptos` WHERE idprefactura = ".$idPrefactura;
			$resultado = $this->conexion->query($consulta);
			if($resultado)
			{
				$numCotizacion = $resultado->fetch_assoc();
				if($numCotizacion > 0)
				{
					$consulta = "SELECT os.idorden,CONCAT('OS-',c.clave_cliente,'-',os.anio,'-',os.norden) AS ordenServicio FROM tblordenesdeservicio os LEFT JOIN tblclientes c ON os.idcliente = c.idclientes WHERE os.idorden IN(SELECT idorden FROM `tblordenesconceptos` WHERE idpfconcepto IN(SELECT idprefacturaconcepto AS idpfconcepto FROM `tblprefacturasconceptos` WHERE idprefactura = ".$idPrefactura."))";
					$resultado = $this->conexion->query($consulta);
					if($resultado)
					{
						while($ordenesServicio = $resultado->fetch_assoc())
						{
							$datosOs[] = $ordenesServicio;
						}
						if(count($datosOs) > 0)
						{
							return $datosOs;
						}
						else
						{
							return "NO EXISTEN OS";
						}
					}
					else
					{
						$datosOs = $this->conexion->errno . " : " . $this->conexion->error . "\n";
					}	
				}
			}
		}
		public function proceso($tipoProceso,$idConcepto,$folioFactura)
		{
			$origen = "";
			switch ($tipoProceso) 
			{
				case 'ABC':
					$consulta = "SELECT CONCAT('COT-',ct.clave_cliente,'-',c.anio,'-',c.ncotizacion) AS cot ,CONCAT('OS-',ct.clave_cliente,'-',os.anio,'-',os.norden) AS os FROM tblordenesconceptos oc LEFT JOIN tblordenesdeservicio os ON os.idorden = oc.idorden LEFT JOIN tblclientes ct ON ct.idclientes = os.idcliente LEFT JOIN tblcotizacionconceptos cc ON oc.idcotconcepto = cc.idcotconcepto LEFT JOIN tblcotizaciones c ON c.id = cc.idcotizacion WHERE oc.idordconcepto = ".$idConcepto;
					$resultado = $this->conexion->query($consulta);
					if($resultado)
					{
						while($folios = $resultado->fetch_assoc())
						{
							$foliosProceso[] = $folios;
						}
						if(isset($foliosProceso))
						{
							foreach ($foliosProceso as $valueFolios) 
							{
								$origen .= $valueFolios["cot"]." <span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> ".$valueFolios["os"]." <span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> ".$folioFactura."<br>";
							}
						}
					}
					break;
				case 'ACB':
					$consulta = "SELECT CONCAT('COT-',ct.clave_cliente,'-',c.anio,'-',c.ncotizacion) AS cot ,CONCAT('OS-',ct.clave_cliente,'-',os.anio,'-',os.norden) AS os FROM tblprefacturasconceptos pc LEFT JOIN tblprefacturas p ON p.idprefactura = pc.idprefactura LEFT JOIN tblclientes ct ON ct.idclientes = p.idcliente LEFT JOIN tblcotizacionconceptos cc ON pc.idcotconcepto = cc.idcotconcepto LEFT JOIN tblcotizaciones c ON c.id = cc.idcotizacion LEFT JOIN tblordenesconceptos oc ON oc.idpfconcepto = pc.idprefacturaconcepto LEFT JOIN tblordenesdeservicio os ON os.idorden = oc.idorden WHERE pc.idcotconcepto = ".$idConcepto;
					$resultado = $this->conexion->query($consulta);
					if($resultado)
					{
						while ($folios = $resultado->fetch_assoc()) 
						{
							$foliosProceso[] = $folios;
						}
						if(isset($foliosProceso))
						{
							foreach ($foliosProceso as $valueFolios) 
							{
								$origen .= $valueFolios["cot"]." <span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> ".$folioFactura;
								if($valueFolios["os"] != "")
									$origen .= " <span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> ".$valueFolios["os"]." <br>";
							}
						}
					}
					break;
				
				default:
					# code...
					break;
			}
			return $origen;
		}

   		public function __destruct() 
   		{
			mysqli_close($this->conexion);
		}
   	}