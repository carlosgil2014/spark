<?php 
	require_once('../db/conectadb.php');
	
	class reportes{



		protected $acceso;

 		protected $conexion;



		public function __construct() {

			$this->acceso = new accesoDB(); 

 		 	$this->conexion = $this->acceso->conDB();

   		} 

   		public function reporteVentas($datos,$campos){
			ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	        header("Content-Disposition: attachment; filename=ReporteVentas.csv");
			header("Content-Type: application/vnd.ms-excel;");
			header("Pragma: no-cache");
			header("Expires: 0");
   			foreach ($datos as $dato) {
               $idOrden = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dato["idorden"])))); 
               $idsOrdenes[] = $idOrden;
            }

            $subconsulta = "";
            $subconsulta = implode(",", $idsOrdenes);	

			$listaCampos = array();
			$idsPrefacturasConceptos = array();
			$descuentos = array();
			$consulta = "SELECT osc.idpfconcepto, osc.idordconcepto FROM tblordenesdeservicio os LEFT OUTER JOIN tblordenesconceptos osc ON os.idorden = osc.idorden WHERE os.idorden IN (".$subconsulta.")";
			// echo $consulta;

			$resultadoConceptos = $this->conexion->query($consulta);
			$out = fopen("php://output", 'w');  
			
			foreach ($campos as $campo) {
				switch ($campo) 
				{
					case 'CLIENTE':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA INICIAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA FINAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ORDEN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PREFACTURA': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo))));
									   $listaCampos[] = "FECHA FACTURACION";	break;
					case 'CFDI': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CONCEPTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CANTIDAD': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO UNITARIO':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO TOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN ($)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN (%)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'SUBTOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE PLAN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE SERVICIO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ELABORÓ':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ESTADO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'MOTIVO DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					default: /*nada...*/ break;
				}
			}
			
			fputcsv($out,array_map("utf8_decode",$listaCampos));
			while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {
				$datosCamposOrden = array();
				$consulta="SELECT os.fechaInicial,os.fechaFinal,os.norden,os.anio,osc.cantidad,os.realizo,cl.clave_cliente,osc.tipoplan,osc.tiposervicio,osc.concepto,osc.precioUnitario,osc.comision,osc.total,osc.descripcion FROM tblordenesdeservicio os LEFT JOIN tblordenesconceptos osc ON os.idorden = osc.idorden LEFT JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE osc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";
					$resultado = $this->conexion->query($consulta); 
					$datosOrden = $resultado->fetch_array();
					$subtotal = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]*(1+($datosOrden["comision"]/100));
				foreach ($campos as $campo) {
					switch ($campo) 
					{
						case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
						case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
						case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
						case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
						case 'PREFACTURA': $datosCamposOrden[] = ""; $datosCamposOrden[] = "";	break;
						case 'CFDI': $datosCamposOrden[] = ""; break;
						case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
						case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
						case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
						case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
						case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
						case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
						case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
						case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
						case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
						case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
						case 'ESTADO': $datosCamposOrden[] = "OS PRINCIPAL"; break;
						case 'DESCUENTO': $datosCamposOrden[] = ""; break;
						case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
						default: /*nada...*/ break;
					}
				}
				fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
				if(is_null($filaTmpConcepto["idpfconcepto"])){ // Caso abc
					$consulta="SELECT pfc.idprefactura,COALESCE(pfc.cantidad,0) as cantidadPf,pf.fechacfdi,pfc.concepto as conceptoPf,pfc.tipoplan,pfc.tiposervicio,pf.fechaInicial,pfc.precioUnitario as precioUnitarioPf,pfc.comision as comisionPf,pfc.total as totalPf,cl.clave_cliente as clavePf, pf.anio as anioPf, pf.nprefactura, pf.realizo,pf.descuento,pf.motivodescuento,pf.cfdi FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.estado != 'Cancelada' AND pfc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";

						$resultado = $this->conexion->query($consulta);
					if($resultado->num_rows != 0){	
						$sumCantidad = 0;	
						$sumSubtotal = 0;
						while ($datosConceptoPrefactura = $resultado->fetch_assoc()) {
							if(!in_array($datosConceptoPrefactura['idprefactura'], $descuentos))
							{
								$descuentoAbc = $datosConceptoPrefactura["descuento"];
								$motivoAbc = $datosConceptoPrefactura["motivodescuento"];
								array_push($descuentos,$datosConceptoPrefactura['idprefactura']);
							}
							else{
								$descuentoAbc = "";
								$motivoAbc = "";
							}
							$datosCamposPrefactura = array();
							$sumCantidad += $datosConceptoPrefactura["cantidadPf"];
							$sumSubtotal += $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100));
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
									case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
									case 'ORDEN': $datosCamposPrefactura[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposPrefactura[] = "PF-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];
													   $datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"];	break;
									case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;
									case 'CONCEPTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["conceptoPf"]; break;
									case 'CANTIDAD': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]; break;
									case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosConceptoPrefactura["precioUnitarioPf"]; break;
									case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]; break;
									case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*($datosConceptoPrefactura["comisionPf"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosConceptoPrefactura["comisionPf"]; break;
									case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100)),2); break;
									case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
									case 'ESTADO': $datosCamposPrefactura[] = "FACTURADO"; break;
									case 'DESCUENTO': $datosCamposPrefactura[] =  $descuentoAbc; break;
									case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] =  $motivoAbc; break;
									default: /*nada...*/ break;
								}
							}

							fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
						}

						if($sumCantidad < $datosOrden["cantidad"] && ($sumSubtotal < ($subtotal + .05))){
							$datosCamposOrden = array();
							$disponible = $datosOrden["cantidad"] - $sumCantidad;
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
									case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
									case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposOrden[] = ""; $datosCamposOrden[] = "";	break;
									case 'CFDI': $datosCamposOrden[] = ""; break;
									case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
									case 'CANTIDAD': $datosCamposOrden[] = $disponible; break;
									case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
									case 'PRECIO TOTAL': $datosCamposOrden[] = $disponible*$datosOrden["precioUnitario"]; break;
									case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($disponible*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
									case 'SUBTOTAL': $datosCamposOrden[] = number_format($disponible*$datosOrden["precioUnitario"]*(1+($datosOrden["comision"]/100)),2); break;
									case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
									case 'ESTADO': $datosCamposOrden[] = "POR FACTURAR"; break;
									case 'DESCUENTO': $datosCamposOrden[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
									default: /*nada...*/ break;
								}
							}

							fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
						}

					}
					else{

						$datosCamposOrden = array();
						foreach ($campos as $campo) {
							switch ($campo) 
							{
								case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
								case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
								case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
								case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
								case 'PREFACTURA': $datosCamposOrden[] = ""; $datosCamposOrden[] = "";	break;
								case 'CFDI': $datosCamposOrden[] = ""; break;
								case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
								case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
								case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
								case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
								case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
								case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
								case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
								case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
								case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
								case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
								case 'ESTADO': $datosCamposOrden[] = "POR FACTURAR"; break;
								case 'DESCUENTO': $datosCamposOrden[] = ""; break;
								case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
								default: /*nada...*/ break;
							}
						}						
						fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
					}
				}
				else //Caso acb 
				{
					if(!in_array($filaTmpConcepto['idpfconcepto'], $idsPrefacturasConceptos))
					{
						array_push($idsPrefacturasConceptos,$filaTmpConcepto['idpfconcepto']);
						$consulta="SELECT pfc.idprefactura,COALESCE(pfc.cantidad,0) as cantidadPf,pf.fechacfdi,pfc.concepto as conceptoPf,pfc.tipoplan,pfc.tiposervicio,pf.fechaInicial,pfc.precioUnitario as precioUnitarioPf,pfc.comision as comisionPf,pfc.total as totalPf,cl.clave_cliente as clavePf, pf.anio as anioPf, pf.nprefactura, pf.realizo,pf.cfdi,pf.descuento,pf.motivodescuento FROM tblprefacturasconceptos pfc LEFT OUTER JOIN tblprefacturas pf ON pfc.idprefactura = pf.idprefactura LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.estado != 'Cancelada' AND pfc.idprefacturaconcepto = '".$filaTmpConcepto['idpfconcepto']."'";

						$resultado = $this->conexion->query($consulta);
						$datosConceptoPrefactura = $resultado->fetch_assoc();
						$datosCamposPrefactura = array();
						if(!in_array($datosConceptoPrefactura['idprefactura'], $descuentos))
						{
							$descuentoAcb = $datosConceptoPrefactura["descuento"];
							$motivoAcb = $datosConceptoPrefactura["motivodescuento"];
							array_push($descuentos,$datosConceptoPrefactura['idprefactura']);
						}
						else{
							$descuentoAcb = "";
							$motivoAcb = "";
						}
						foreach ($campos as $campo) {
							switch ($campo) 
							{
								case 'CLIENTE':	$datosCamposPrefactura[] = $datosConceptoPrefactura["clavePf"]; break;
								case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["fechaInicial"]; break;
								case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
								case 'ORDEN': $datosCamposPrefactura[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
								case 'PREFACTURA': $datosCamposPrefactura[] = "PF-".$datosConceptoPrefactura["clavePf"]."-".$datosConceptoPrefactura["anioPf"]."-".$datosConceptoPrefactura["nprefactura"];	
												   $datosCamposPrefactura[] = $datosConceptoPrefactura["fechacfdi"];break;
								case 'CFDI': $datosCamposPrefactura[] = $datosConceptoPrefactura["cfdi"]; break;
								case 'CONCEPTO': $datosCamposPrefactura[] = $datosConceptoPrefactura["conceptoPf"]; break;
								case 'CANTIDAD': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]; break;
								case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosConceptoPrefactura["precioUnitarioPf"]; break;
								case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]; break;
								case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*($datosConceptoPrefactura["comisionPf"]/100),2); break;
								case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosConceptoPrefactura["comisionPf"]; break;
								case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($datosConceptoPrefactura["cantidadPf"]*$datosConceptoPrefactura["precioUnitarioPf"]*(1+($datosConceptoPrefactura["comisionPf"]/100)),2); break;
								case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosConceptoPrefactura["tipoplan"]; break;
								case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosConceptoPrefactura["tiposervicio"]; break;
								case 'ELABORÓ':	$datosCamposPrefactura[] = $datosConceptoPrefactura["realizo"]; break;
								case 'ESTADO': $datosCamposPrefactura[] = "FACTURADO"; break;
								case 'DESCUENTO': $datosCamposPrefactura[] = $descuentoAcb; break;
								case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = $motivoAcb; break;
								default: /*nada...*/ break;
							}
						}
						fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));

						//CONSULTA POR REALIZAR 

						$datosCamposPrefactura = array();
						$consulta="SELECT pfc.idprefactura,pf.fechaInicial,pf.nprefactura,pf.fechacfdi,pf.anio,pf.cfdi,pf.descuento,pf.motivodescuento,pfc.cantidad,pf.realizo,cl.clave_cliente,pfc.tipoplan,pfc.tiposervicio,pfc.concepto,pfc.precioUnitario,pfc.comision,pfc.total FROM tblprefacturas pf LEFT JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura LEFT JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pfc.idprefacturaconcepto = '".$filaTmpConcepto['idpfconcepto']."'";
							$resultado = $this->conexion->query($consulta); 
							$datosPrefactura = $resultado->fetch_array();
							$subtotal = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*(1+($datosPrefactura["comision"]/100));

						$consulta="SELECT osc.idorden,COALESCE(osc.cantidad,0) as cantidadOs,osc.concepto as conceptoOs,osc.tipoplan,osc.tiposervicio,os.fechaInicial,os.fechaFinal,osc.precioUnitario as precioUnitarioOs,osc.comision as comisionOs,osc.total as totalOs,cl.clave_cliente as claveOs, os.anio as anioOs, os.norden, os.realizo FROM tblordenesconceptos osc LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND osc.idpfconcepto = '".$filaTmpConcepto['idpfconcepto']."'";

							$resultado = $this->conexion->query($consulta);
						if($resultado->num_rows != 0){	
							$sumCantidad = 0;	
							$sumSubtotal = 0;
							while ($datosConceptoOrden = $resultado->fetch_assoc()) {
								$datosCamposOrden = array();
								$sumCantidad += $datosConceptoOrden["cantidadOs"];
								$sumSubtotal += $datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*(1+($datosConceptoOrden["comisionOs"]/100));
							}

							if(($sumSubtotal < ($subtotal))){
								$datosCamposPrefactura = array();
								$disponible = ($subtotal - $sumSubtotal) / (1+($datosPrefactura["comision"]/100));
								foreach ($campos as $campo) {
									switch ($campo) 
									{
										case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
										case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
										case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
										case 'ORDEN': $datosCamposPrefactura[] = ""; break;
										case 'PREFACTURA': $datosCamposPrefactura[] = "PF-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	 
														   $datosCamposPrefactura[] = $datosPrefactura["fechacfdi"];break;
										case 'CFDI': $datosCamposPrefactura[] = ""; break;
										case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
										case 'CANTIDAD': $datosCamposPrefactura[] = 1; break;
										case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $disponible; break;
										case 'PRECIO TOTAL': $datosCamposPrefactura[] = 1*$disponible; break;
										case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format(1*$disponible*($datosPrefactura["comision"]/100),2); break;
										case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
										case 'SUBTOTAL': $datosCamposPrefactura[] = number_format(1*$disponible*(1+($datosPrefactura["comision"]/100)),2); break;
										case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
										case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
										case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
										case 'ESTADO': $datosCamposPrefactura[] = "POR REALIZAR"; break;
										case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
										case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = ""; break;
										default: /*nada...*/ break;
									}
								}

								fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
							}

						}
						//FIN CONSULTA POR REALIZAR 

						// CONSULTA OS ANTICIPADAS EN REVISION 
						$consulta="SELECT os.fechaInicial,os.fechaFinal,os.norden,os.anio,osc.cantidad,os.realizo,cl.clave_cliente,osc.tipoplan,osc.tiposervicio,osc.concepto,osc.precioUnitario,osc.comision,osc.total,osc.descripcion FROM tblordenesdeservicio os LEFT JOIN tblordenesconceptos osc ON os.idorden = osc.idorden LEFT JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado = 'Por autorizar' AND osc.idpfconcepto = '".$filaTmpConcepto['idpfconcepto']."'";
							$resultado = $this->conexion->query($consulta); 
						while ($datosOrden = $resultado->fetch_array()) {
							$datosCamposOrden = array();
							$subtotal = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]*(1+($datosOrden["comision"]/100));
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
									case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
									case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposOrden[] = "PF-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	 
														$datosCamposOrden[] = $datosPrefactura["fechacfdi"];	break;
									case 'CFDI': $datosCamposOrden[] = ""; break;
									case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
									case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
									case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
									case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
									case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
									case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
									case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
									case 'ESTADO': $datosCamposOrden[] = "EN REVISION"; break;
									case 'DESCUENTO': $datosCamposOrden[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
									default: /*nada...*/ break;
								}
							}
							fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
						}
						// FIN CONSULTA OS ANTICIPADAS EN REVISION
						// CONSULTA OTRAS OS INVOLUCRADAS AUTORIZADAS  
						$consulta="SELECT os.fechaInicial,os.fechaFinal,os.norden,os.anio,osc.cantidad,os.realizo,cl.clave_cliente,osc.tipoplan,osc.tiposervicio,osc.concepto,osc.precioUnitario,osc.comision,osc.total,osc.descripcion FROM tblordenesdeservicio os LEFT JOIN tblordenesconceptos osc ON os.idorden = osc.idorden LEFT JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.idorden NOT IN (".$subconsulta.") AND os.estado = 'Autorizada' AND osc.idpfconcepto = '".$filaTmpConcepto['idpfconcepto']."'";
							$resultado = $this->conexion->query($consulta); 
						while ($datosOrden = $resultado->fetch_array()) {
							$datosCamposOrden = array();
							$subtotal = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]*(1+($datosOrden["comision"]/100));
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposOrden[] = $datosOrden["clave_cliente"]; break;
									case 'FECHA INICIAL': $datosCamposOrden[] = $datosOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposOrden[] = $datosOrden["fechaFinal"]; break;
									case 'ORDEN': $datosCamposOrden[] = "OS-".$datosOrden["clave_cliente"]."-".$datosOrden["anio"]."-".$datosOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposOrden[] = "PF-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	 
														$datosCamposOrden[] = $datosPrefactura["fechacfdi"];	break;
									case 'CFDI': $datosCamposOrden[] = ""; break;
									case 'CONCEPTO': $datosCamposOrden[] = $datosOrden["concepto"]; break;
									case 'CANTIDAD': $datosCamposOrden[] = $datosOrden["cantidad"]; break;
									case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosOrden["precioUnitario"]; break;
									case 'PRECIO TOTAL': $datosCamposOrden[] = $datosOrden["cantidad"]*$datosOrden["precioUnitario"]; break;
									case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosOrden["cantidad"]*$datosOrden["precioUnitario"]*($datosOrden["comision"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposOrden[] = $datosOrden["comision"]; break;
									case 'SUBTOTAL': $datosCamposOrden[] = number_format($subtotal,2); break;
									case 'TIPO DE PLAN': $datosCamposOrden[] = $datosOrden["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosOrden["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposOrden[] = $datosOrden["realizo"]; break;
									case 'ESTADO': $datosCamposOrden[] = "OTRAS"; break;
									case 'DESCUENTO': $datosCamposOrden[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
									default: /*nada...*/ break;
								}
							}
							fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
						}
						// FIN CONSULTA OS INVOLUCRADAS AUTORIZADAS  
					}
				}
			}
			fclose($out);
		}

		public function datosFactura($idClientes,$fechaInicial,$fechaFinal){



			$datos = array();

			$fechaInicial = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaInicial))));

			$fechaFinal = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($fechaFinal))));

			foreach ($idClientes as $idCliente) {
				$idCliente = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($idCliente)))); 
               	$idsClientes[] = $idCliente;
            }

            $subconsulta = "";
            $subconsulta = implode(",", $idsClientes);

			$consulta = "SELECT pf.idprefactura,cl.clave_cliente, pf.anio, pf.nprefactura,pf.detalle, pf.fechaInicial, pf.estado,pf.cfdi, (SELECT SUM(total) as total FROM tblprefacturasconceptos WHERE idprefactura = pf.idprefactura) - pf.descuento as total FROM tblprefacturas pf LEFT JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.idcliente IN (".$subconsulta.") AND pf.estado != 'Cancelada' and ((pf.fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or (pf.fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'))";

				$resultado = $this->conexion->query($consulta);

				if($resultado){

					while ($filaTmp = $resultado->fetch_assoc()) {

						$datos[] =  $filaTmp;

					}

				}

				else{

					return $this->conexion->errno . " : " . $this->conexion->error . "\n";

				}

			

			return $datos;

		}


		public function reporteFacturacion($datos,$campos){
			ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	        header("Content-Disposition: attachment; filename=ReporteFacturacion.csv");
			header("Content-Type: application/vnd.ms-excel;");
			header("Pragma: no-cache");
			header("Expires: 0");
   			foreach ($datos as $dato) {
               $idPrefactura = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($dato["idprefactura"])))); 
               $idsPrefacturas[] = $idPrefactura;
            }

            $subconsulta = "";
            $subconsulta = implode(",", $idsPrefacturas);	

			$listaCampos = array();

			$consulta = "SELECT pfc.idprefacturaconcepto, pfc.idordconcepto FROM tblprefacturasconceptos pfc WHERE pfc.idprefactura IN (".$subconsulta.")";
			// echo $consulta;

			$resultadoConceptos = $this->conexion->query($consulta);
			$out = fopen("php://output", 'w');  
			
			foreach ($campos as $campo) {
				switch ($campo) 
				{
					case 'CLIENTE':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA INICIAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'FECHA FINAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ORDEN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PREFACTURA': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo))));	break;
					case 'CFDI': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CONCEPTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'CANTIDAD': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO UNITARIO':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'PRECIO TOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN ($)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'COMISIÓN (%)': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'SUBTOTAL': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE PLAN': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'TIPO DE SERVICIO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ELABORÓ':	$listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'ESTADO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					case 'MOTIVO DESCUENTO': $listaCampos[] = $this->conexion -> real_escape_string(strip_tags(stripslashes(trim($campo)))); break;
					default: /*nada...*/ break;
				}
			}
			
			fputcsv($out,array_map("utf8_decode",$listaCampos));
			$prefactura = 0;
			while ($filaTmpConcepto = $resultadoConceptos->fetch_assoc()) {
				$datosCamposPrefactura = array();
				$consulta="SELECT pfc.idprefactura,pf.fechaInicial,pf.nprefactura,pf.anio,pf.cfdi,pf.descuento,pf.motivodescuento,pfc.cantidad,pf.realizo,cl.clave_cliente,pfc.tipoplan,pfc.tiposervicio,pfc.concepto,pfc.precioUnitario,pfc.comision,pfc.total FROM tblprefacturas pf LEFT JOIN tblprefacturasconceptos pfc ON pf.idprefactura = pfc.idprefactura LEFT JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pfc.idprefacturaconcepto = '".$filaTmpConcepto['idprefacturaconcepto']."'";
					$resultado = $this->conexion->query($consulta); 
					$datosPrefactura = $resultado->fetch_array();
					$subtotal = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*(1+($datosPrefactura["comision"]/100));
					if($prefactura != $datosPrefactura["idprefactura"]){
						$prefactura = $datosPrefactura["idprefactura"];
						$bandera = 1;
					}
					else{
						$bandera = 0;
					}
				foreach ($campos as $campo) {
					switch ($campo) 
					{
						case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
						case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
						case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
						case 'ORDEN': $datosCamposPrefactura[] = ""; break;
						case 'PREFACTURA': $datosCamposPrefactura[] = "PF-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	break;
						case 'CFDI': $datosCamposPrefactura[] = $datosPrefactura["cfdi"]; break;
						case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
						case 'CANTIDAD': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]; break;
						case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosPrefactura["precioUnitario"]; break;
						case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]; break;
						case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*($datosPrefactura["comision"]/100),2); break;
						case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
						case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($subtotal,2); break;
						case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
						case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
						case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
						case 'ESTADO': $datosCamposPrefactura[] = "PF PRINCIPAL"; break;
						case 'DESCUENTO': if($bandera == 1 ) $datosCamposPrefactura[] = $datosPrefactura["descuento"]; break;
						case 'MOTIVO DESCUENTO': if($bandera == 1 ) $datosCamposPrefactura[] = $datosPrefactura["motivodescuento"]; break;
						default: /*nada...*/ break;
					}
				}
				fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
				if(is_null($filaTmpConcepto["idordconcepto"])){ // Caso acb
					$consulta="SELECT osc.idorden,COALESCE(osc.cantidad,0) as cantidadOs,osc.concepto as conceptoOs,osc.tipoplan,osc.tiposervicio,os.fechaInicial,os.fechaFinal,osc.precioUnitario as precioUnitarioOs,osc.comision as comisionOs,osc.total as totalOs,cl.clave_cliente as claveOs, os.anio as anioOs, os.norden, os.realizo FROM tblordenesconceptos osc LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND osc.idpfconcepto = '".$filaTmpConcepto['idprefacturaconcepto']."'";

						$resultado = $this->conexion->query($consulta);
					if($resultado->num_rows != 0){	
						$sumCantidad = 0;	
						$sumSubtotal = 0;
						while ($datosConceptoOrden = $resultado->fetch_assoc()) {
							$datosCamposOrden = array();
							$sumCantidad += $datosConceptoOrden["cantidadOs"];
							$sumSubtotal += $datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*(1+($datosConceptoOrden["comisionOs"]/100));
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposOrden[] = $datosConceptoOrden["claveOs"]; break;
									case 'FECHA INICIAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposOrden[] = $datosConceptoOrden["fechaFinal"]; break;
									case 'ORDEN': $datosCamposOrden[] = "OS-".$datosConceptoOrden["claveOs"]."-".$datosConceptoOrden["anioOs"]."-".$datosConceptoOrden["norden"]; break;
									case 'PREFACTURA': $datosCamposOrden[] = "PF-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	break;
									case 'CFDI': $datosCamposOrden[] = ""; break;
									case 'CONCEPTO': $datosCamposOrden[] = $datosConceptoOrden["conceptoOs"]; break;
									case 'CANTIDAD': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]; break;
									case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosConceptoOrden["precioUnitarioOs"]; break;
									case 'PRECIO TOTAL': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]; break;
									case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*($datosConceptoOrden["comisionOs"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposOrden[] = $datosConceptoOrden["comisionOs"]; break;
									case 'SUBTOTAL': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*(1+($datosConceptoOrden["comisionOs"]/100)),2); break;
									case 'TIPO DE PLAN': $datosCamposOrden[] = $datosConceptoOrden["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosConceptoOrden["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposOrden[] = $datosConceptoOrden["realizo"]; break;
									case 'ESTADO': $datosCamposOrden[] = "REALIZADA"; break;
									case 'DESCUENTO': $datosCamposOrden[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
									default: /*nada...*/ break;
								}
							}

							fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
						}

						if(($sumSubtotal < ($subtotal))){
							$datosCamposPrefactura = array();
							$disponible = ($subtotal - $sumSubtotal) / (1+($datosPrefactura["comision"]/100));
							foreach ($campos as $campo) {
								switch ($campo) 
								{
									case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
									case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
									case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
									case 'ORDEN': $datosCamposPrefactura[] = ""; break;
									case 'PREFACTURA': $datosCamposPrefactura[] = "PF-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	break;
									case 'CFDI': $datosCamposPrefactura[] = ""; break;
									case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
									case 'CANTIDAD': $datosCamposPrefactura[] = 1; break;
									case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $disponible; break;
									case 'PRECIO TOTAL': $datosCamposPrefactura[] = 1*$disponible; break;
									case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format(1*$disponible*($datosPrefactura["comision"]/100),2); break;
									case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
									case 'SUBTOTAL': $datosCamposPrefactura[] = number_format(1*$disponible*(1+($datosPrefactura["comision"]/100)),2); break;
									case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
									case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
									case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
									case 'ESTADO': $datosCamposPrefactura[] = "POR REALIZAR"; break;
									case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
									case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = ""; break;
									default: /*nada...*/ break;
								}
							}

							fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
						}

					}
					else{

						$datosCamposPrefactura = array();
						foreach ($campos as $campo) {
							switch ($campo) 
							{
								case 'CLIENTE':	$datosCamposPrefactura[] = $datosPrefactura["clave_cliente"]; break;
								case 'FECHA INICIAL': $datosCamposPrefactura[] = $datosPrefactura["fechaInicial"]; break;
								case 'FECHA FINAL': $datosCamposPrefactura[] = ""; break;
								case 'ORDEN': $datosCamposPrefactura[] = ""; break;
								case 'PREFACTURA': $datosCamposPrefactura[] = "PF-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	break;
								case 'CFDI': $datosCamposPrefactura[] = ""; break;
								case 'CONCEPTO': $datosCamposPrefactura[] = $datosPrefactura["concepto"]; break;
								case 'CANTIDAD': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]; break;
								case 'PRECIO UNITARIO':	$datosCamposPrefactura[] = $datosPrefactura["precioUnitario"]; break;
								case 'PRECIO TOTAL': $datosCamposPrefactura[] = $datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]; break;
								case 'COMISIÓN ($)': $datosCamposPrefactura[] = number_format($datosPrefactura["cantidad"]*$datosPrefactura["precioUnitario"]*($datosPrefactura["comision"]/100),2); break;
								case 'COMISIÓN (%)': $datosCamposPrefactura[] = $datosPrefactura["comision"]; break;
								case 'SUBTOTAL': $datosCamposPrefactura[] = number_format($subtotal,2); break;
								case 'TIPO DE PLAN': $datosCamposPrefactura[] = $datosPrefactura["tipoplan"]; break;
								case 'TIPO DE SERVICIO': $datosCamposPrefactura[] = $datosPrefactura["tiposervicio"]; break;
								case 'ELABORÓ':	$datosCamposPrefactura[] = $datosPrefactura["realizo"]; break;
								case 'ESTADO': $datosCamposPrefactura[] = "POR REALIZAR"; break;
								case 'DESCUENTO': $datosCamposPrefactura[] = ""; break;
								case 'MOTIVO DESCUENTO': $datosCamposPrefactura[] = ""; break;
								default: /*nada...*/ break;
							}
						}						
						fputcsv($out,array_map("utf8_decode",$datosCamposPrefactura));
					}
				}
				else //Caso acb 
				{
					$consulta="SELECT osc.idorden,COALESCE(osc.cantidad,0) as cantidadOs,osc.concepto as conceptoOS,osc.tipoplan,osc.tiposervicio,os.fechaInicial,os.fechaFinal,osc.precioUnitario as precioUnitarioOs,osc.comision as comisionOs,osc.total as totalOS,cl.clave_cliente as claveOs, os.anio as anioOs, os.norden, os.realizo FROM tblordenesconceptos osc LEFT OUTER JOIN tblordenesdeservicio os ON osc.idorden = os.idorden LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.estado != 'Cancelada' AND osc.idordconcepto = '".$filaTmpConcepto['idordconcepto']."'";

					$resultado = $this->conexion->query($consulta);
					$datosConceptoOrden = $resultado->fetch_assoc();
					$datosCamposOrden = array();
					foreach ($campos as $campo) {
						switch ($campo) 
						{
							case 'CLIENTE':	$datosCamposOrden[] = $datosConceptoOrden["claveOs"]; break;
							case 'FECHA INICIAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
							case 'FECHA FINAL': $datosCamposOrden[] = $datosConceptoOrden["fechaInicial"]; break;
							case 'ORDEN': $datosCamposOrden[] = "OS-".$datosConceptoOrden["claveOs"]."-".$datosConceptoOrden["anioOs"]."-".$datosConceptoOrden["norden"]; break;
							case 'PREFACTURA': $datosCamposOrden[] = "PF-".$datosPrefactura["clave_cliente"]."-".$datosPrefactura["anio"]."-".$datosPrefactura["nprefactura"];	break;
							case 'CFDI': $datosCamposOrden[] = ""; break;
							case 'CONCEPTO': $datosCamposOrden[] = $datosConceptoOrden["conceptoOS"]; break;
							case 'CANTIDAD': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]; break;
							case 'PRECIO UNITARIO':	$datosCamposOrden[] = $datosConceptoOrden["precioUnitarioOs"]; break;
							case 'PRECIO TOTAL': $datosCamposOrden[] = $datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]; break;
							case 'COMISIÓN ($)': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*($datosConceptoOrden["comisionOs"]/100),2); break;
							case 'COMISIÓN (%)': $datosCamposOrden[] = $datosConceptoOrden["comisionOs"]; break;
							case 'SUBTOTAL': $datosCamposOrden[] = number_format($datosConceptoOrden["cantidadOs"]*$datosConceptoOrden["precioUnitarioOs"]*(1+($datosConceptoOrden["comisionOs"]/100)),2); break;
							case 'TIPO DE PLAN': $datosCamposOrden[] = $datosConceptoOrden["tipoplan"]; break;
							case 'TIPO DE SERVICIO': $datosCamposOrden[] = $datosConceptoOrden["tiposervicio"]; break;
							case 'ELABORÓ':	$datosCamposOrden[] = $datosConceptoOrden["realizo"]; break;
							case 'ESTADO': $datosCamposOrden[] = "REALIZADA"; break;
							case 'DESCUENTO': $datosCamposOrden[] = ""; break;
							case 'MOTIVO DESCUENTO': $datosCamposOrden[] = ""; break;
							default: /*nada...*/ break;
						}
					}

					fputcsv($out,array_map("utf8_decode",$datosCamposOrden));
				}
			}
			fclose($out);
		}


		public function __destruct() {

				mysqli_close($this->conexion);

  		}

	}

?>