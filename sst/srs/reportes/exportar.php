<?php
require_once('../conexion.php');

$idCots = explode(",",mysql_real_escape_string($_POST["idCot"]));
$idOrdSer = explode(",",mysql_real_escape_string($_POST["idOrdServicio"]));
$idpFacturas = explode(",",mysql_real_escape_string($_POST["idpFactura"]));
$idFacturas = explode(",",mysql_real_escape_string($_POST["idFactura"]));
$tipoPlan=mysql_real_escape_string($_POST['tipoPLan']);
$tipoServicio= mysql_real_escape_string($_POST['tipoServicio']);
$arregloOrd=array();
$arregloPf=array();
$campos = explode(",",mysql_real_escape_string($_POST["campos"]));
$listaCampos = array();
$datosCampos = array();
ini_set ( 'max_execution_time' ,  300 );
$cont=0;

if($idCots!=[0] || $idOrdSer!=[0] || $idpFacturas!=[0] || $idFacturas!=[0])
{
	header("Content-Disposition: attachment; filename=Reporte.csv");
	header("Content-Type: application/vnd.ms-excel;");
	header("Pragma: no-cache");
	header("Expires: 0");
}

	if($idCots!=[0])
	{
		
		//$idCotOsPf=0;
		$folioOrdEspecifica="";
		$folioPfEspecifica="";
		$cfdiPfEspecifico="";
		$fechaCFDI="";

		for($i=0;$i < sizeof($idCots);$i++)
		{
			//echo $ids[$i];
			$queryFolio="SELECT cl.clave_cliente as clave, c.ncotizacion,c.anio,c.servicio,c.realizo,c.estado,c.fechaInicial,c.fechaFinal FROM tblcotizaciones c LEFT OUTER JOIN tblclientes cl ON c.idcliente = cl.idclientes WHERE c.id=".$idCots[$i];
			$resulFolio= mysql_query($queryFolio,$conexion) or die(mysql_error());
			$cotFolio= mysql_fetch_assoc($resulFolio);
			$queryElaboro="SELECT * FROM tblusuarios WHERE user_name='".$cotFolio["realizo"]."'";
			$resultadoElaboro=mysql_query($queryElaboro,$conexion) or die(mysql_error());
			$usuarioElaboro=mysql_fetch_assoc($resultadoElaboro);
		    
			$queryNom="SELECT razon_soc FROM tblclientes where idclientes IN(SELECT idcliente FROM tblcotizaciones WHERE id=".$idCots[$i].")";
			$resulNom=mysql_query($queryNom,$conexion);
			$nom=mysql_fetch_assoc($resulNom);
			//print_r($idCots[$i]);
			$query="SELECT * FROM tblcotizacionconceptos where idcotizacion=".$idCots[$i];
			if($tipoPlan!="Todos" and $tipoServicio!="Todos")
			{
				$query .=" AND (tipoplan='".$tipoPlan."' and tiposervicio='".$tipoServicio."')";
			}
			if($tipoPlan=="Todos" and $tipoServicio!="Todos")
			{
				$query.=" AND (tipoplan!='".$tipoPlan."' and tiposervicio='".$tipoServicio."')";
			}
			if($tipoPlan!="Todos" and $tipoServicio=="Todos")
			{
				$query.=" AND (tipoplan='".$tipoPlan."' and tiposervicio!='".$tipoServicio."')";
			}
			//echo $query;
			//mysql_query("set names 'utf8'",$conexion);
			$resul=mysql_query($query,$conexion) or die(mysql_error());
			while($cotconcepto=mysql_fetch_assoc($resul))                
			{
				//print_r($cotconcepto['idcotconcepto']."-");
				// $queryVerificaExisteOrden="SELECT CASE WHEN tblordenesconceptos.idcotconcepto!='NULL' THEN 0 WHEN tblordenesconceptos.idpfconcepto!='NULL' THEN 1 END AS ORDEN FROM tblordenesconceptos WHERE idorden=";
				$queryOrdEspecifica="SELECT * FROM tblordenesconceptos WHERE idcotconcepto =".$cotconcepto['idcotconcepto'];
				//echo $queryOrdEspecifica;
				$resultadoOrdEspecifica=mysql_query($queryOrdEspecifica,$conexion) or die (mysql_error());
				if(mysql_num_rows($resultadoOrdEspecifica)>0)
				{
					
					while($idOrdEspecificaCcpto=mysql_fetch_assoc($resultadoOrdEspecifica))
					{
						$tipoProceso="ABC";
						//print_r($idOrdEspecificaCcpto['idorden']);
						if(!in_array($idOrdEspecificaCcpto['idorden'],$arregloOrd))
					    {
					        //array_push($arregloOrd,$idOrdEspecificaCcpto['idorden']);
					    	//print_r($idOrdEspecificaCcpto['idorden']);
					    	$queryOrdEspecificaId="SELECT cl.clave_cliente as clave,os.norden,os.anio FROM tblordenesdeservicio os LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.idorden = ".$idOrdEspecificaCcpto['idorden'];
					    	//echo "/".$queryOrdEspecificaId;
							$resultadoOrdEspecifico=mysql_query($queryOrdEspecificaId,$conexion) or die (mysql_error());
							while($idOrdEspecifica=mysql_fetch_assoc($resultadoOrdEspecifico))
							{
								//echo $idOrdEspecificaCcpto['idordconcepto'];
								$queryPrefacturaEspecifica = "SELECT idprefactura from tblprefacturasconceptos WHERE idordconcepto = ".$idOrdEspecificaCcpto['idordconcepto'];
								//echo $queryPrefacturaEspecifica;
							    $resultadoPrefactura =  mysql_query($queryPrefacturaEspecifica,$conexion) or die (mysql_error());
							    while ($prefacturaEspecifica=mysql_fetch_assoc($resultadoPrefactura)) 
							    { 

							    	if(!in_array($prefacturaEspecifica['idprefactura'],$arregloPf))
							      	{
							      		//print_r($prefacturaEspecifica['idprefactura']);
							      		//array_push($arregloPf, $prefacturaEspecifica['idprefactura']);
							      		$queryPrefacturaEspecifica = "SELECT cl.clave_cliente as clave, pf.cfdi,pf.fechacfdi, pf.anio, pf.nprefactura from tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.idprefactura =".$prefacturaEspecifica["idprefactura"]." AND pf.estado != 'Cancelada'";
							    		$resultadoPrefactura =  mysql_query($queryPrefacturaEspecifica,$conexion) or die (mysql_error());
							    		while($prefacturaEspecifica=mysql_fetch_assoc($resultadoPrefactura))
							    		{
							    			$folioPfEspecifica .= "PF-".$prefacturaEspecifica['clave']."-".$prefacturaEspecifica['anio']."-".$prefacturaEspecifica['nprefactura']." ";
							    			$cfdiPfEspecifico .= $prefacturaEspecifica['cfdi']." ";
							    			$fechaCFDI .= $prefacturaEspecifica['fechacfdi']." ";			        		
							        	}
							        }
							    }
							    $folioOrdEspecifica .= "OS-".$idOrdEspecifica["clave"]."-".$idOrdEspecifica["anio"]."-".$idOrdEspecifica["norden"]." ";
							    //echo $folioOrdEspecifica;
					       		
					       	}
					    }
					    

					}
				}
				else
				{
					$tipoProceso = "ACB";
					$arrayOrden=array();
					$arregloPf=array();
					$queryPfEspecifica="SELECT * FROM tblprefacturasconceptos WHERE idcotconcepto =".$cotconcepto['idcotconcepto'];
					//echo $queryPfEspecifica;
					$resultadoPf =  mysql_query($queryPfEspecifica,$conexion) or die (mysql_error());
				    while ($pfEspecifica=mysql_fetch_assoc($resultadoPf)) 
				    { 
				    	//echo $pfEspecifica['idprefacturaconcepto'];
				    	$queryOrden="SELECT * FROM tblordenesconceptos WHERE idpfconcepto=".$pfEspecifica["idprefacturaconcepto"];
				    	//echo $queryOrden;
				    	$resultadoOrden=mysql_query($queryOrden,$conexion) or die (mysql_error());
				    	while($ordenEspecifica=mysql_fetch_assoc($resultadoOrden))
				    	{
				    		if(!in_array($ordenEspecifica["idorden"],$arrayOrden ))
				    		{
				    			//array_push($arrayOrden, $ordenEspecifica["idorden"]);

					    		$queryOrdenServicio="SELECT cl.clave_cliente as clave,os.norden,os.anio  FROM tblordenesdeservicio os LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.idorden=".$ordenEspecifica["idorden"]." AND os.estado != 'Cancelada'";
					    		$resultadoOrdenServicio=mysql_query($queryOrdenServicio,$conexion) or die(mysql_error());
					    		while($ordenServicio=mysql_fetch_assoc($resultadoOrdenServicio))
					    		{
					    			$folioOrdEspecifica .= "OS-".$ordenServicio["clave"]."-".$ordenServicio["anio"]."-".$ordenServicio["norden"]." ";
					    		}
				    		}
				    	}
				    	if(!in_array($pfEspecifica['idprefactura'],$arregloPf))
				      	{
				      		//array_push($arregloPf, $ordenEspecifica["idorden"]);
				      		//print_r($prefacturaEspecifica['idprefactura']);
				      		//array_push($arregloPf, $prefacturaEspecifica['idprefactura']);
				      		$queryPfEspecificaId = "SELECT cl.clave_cliente as clave, pf.cfdi,pf.fechacfdi,pf.nprefactura,pf.anio from tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE idprefactura =".$pfEspecifica["idprefactura"]." AND pf.estado != 'Cancelada'";
				    		$resultadoPf =  mysql_query($queryPfEspecificaId,$conexion) or die (mysql_error());
				    		while($prefacturaEspecifica=mysql_fetch_assoc($resultadoPf))
				    		{
				    			$folioPfEspecifica .= "PF-".$prefacturaEspecifica['clave']."-".$prefacturaEspecifica['anio']."-".$prefacturaEspecifica['nprefactura']." ";
				    			$cfdiPfEspecifico .= $prefacturaEspecifica['cfdi']." ";
				    			$fechaCFDI .= $prefacturaEspecifica['fechacfdi']." ";			        		
				        	}
				        }
				    }
				}
				foreach ($campos as $campo) 
				{
					switch ($campo) 
					{
						case 'COTIZACIÓN':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = "COT-".$cotFolio["clave"]."-".$cotFolio["anio"]."-".$cotFolio["ncotizacion"];
							break;
						case 'ORDEN':
							$listaCampos[] = $campo;
							if($tipoProceso == "ABC")
								$datosCampos[] = $folioOrdEspecifica;
							else
								$datosCampos[] = $folioPfEspecifica;
							break;
						case 'PREFACTURA':
							$listaCampos[] = $campo;
							if($tipoProceso == "ABC")
								$datosCampos[] = $folioPfEspecifica;
							else
								$datosCampos[] = $folioOrdEspecifica;
							break;
						case 'CFDI':
							$listaCampos[] = $campo;
							$datosCampos[] = $cfdiPfEspecifico;
							break;
						case 'FECHA DE CFDI':
							$listaCampos[] = $campo;
							$datosCampos[] = $fechaCFDI;
							break;
						case 'ELABORÓ':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $usuarioElaboro["full_name"];
							break;	
						case 'CLIENTES':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($nom["razon_soc"]);
							break;
						case 'TIPO DE PLAN':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotconcepto["tipoplan"];
							break;
						case 'TIPO DE SERVICIO':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotconcepto["tiposervicio"];
							break;
						case 'CANTIDAD':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotconcepto["cant"];
							break;
						case 'CONCEPTO':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotconcepto["concepto"];
							break;
						case 'NOTA':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotconcepto["descrip"];
							break;
						case 'P. UNITARIO':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotconcepto["precio"];
						 	break;
						case 'P. TOTAL':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotconcepto["preciototal"];
						 	break;
						case 'COMISIÓN ($)':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $cotconcepto["comision"];
							break;
						case 'COMISIÓN (%)':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $cotconcepto["comisionagencia"];
							break;
						case 'SUBTOTAL':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotconcepto["total"];
							break;
						case 'ESTADO':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode("Cotización ".$cotFolio["estado"]);
							break;
						case 'ESTATUS':
							$listaCampos[] = $campo;
							$datosCampos[] = "";
							break;
						case 'DESCUENTO':
							$listaCampos[] = $campo;
							$datosCampos[] = "";
							break;
						case 'MOTIVO DE DESCUENTO':
							$listaCampos[] = $campo;
							$datosCampos[] = "";
							break;
						case 'FECHA INICIAL':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotFolio["fechaInicial"];
							break;
						case 'FECHA FINAL':
							$listaCampos[] = $campo;
							$datosCampos[] = $cotFolio["fechaFinal"];
							break;
						case 'ÚLTIMA MODIFICACIÓN OS':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = "";
							break;	
						default:
							# code...
							break;
					}
				}
				if($tipoProceso == "ABC" || $tipoProceso == "ACB")
				{
					$cont++;
						if($cont==1)
						{
							$lista = array ($listaCampos,$datosCampos);
						}
						else
						{
				       		$lista = array ($datosCampos);
				       	}
				}

					 	$out = fopen("php://output", 'w');
					 	
						foreach ($lista as $data)
						{
				    		fputcsv($out, $data);
						}
						fclose($out);
						$folioOrdEspecifica="";
						$folioPfEspecifica="";
						$cfdiPfEspecifico="";
						$fechaCFDI="";
						$datosCampos = array();
			}		
		}	
	}


	if ($idOrdSer!=[0]) 
	{
		//$cont=0;
		//$idCotOsPf=0;
		$folioCotEspecifica="";
		$folioPfEspecifica="";
		$cfdiPfEspecifico="";
		$fechaCFDI="";

		for($i=0;$i < sizeof($idOrdSer);$i++)
		{
			//echo $ids[$i]."-".$_POST['tipoPLan'];
			$queryFolioOrd="SELECT cl.clave_cliente as clave,os.realizo, os.fechaInicial,os.fechaFinal,os.anio,os.ejecucion,os.estado,os.servicio,os.elaboracion,os.norden  FROM tblordenesdeservicio os LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.idorden=".$idOrdSer[$i];
			$resulFolioOrd= mysql_query($queryFolioOrd,$conexion) or die(mysql_error());
			$ordFolio= mysql_fetch_assoc($resulFolioOrd);
			$queryElaboro="SELECT * FROM tblusuarios WHERE user_name='".$ordFolio["realizo"]."'";
			$resultadoElaboro=mysql_query($queryElaboro,$conexion) or die(mysql_error());
			$usuarioElaboro=mysql_fetch_assoc($resultadoElaboro);
			$queryNom="SELECT razon_soc FROM tblclientes where idclientes IN(SELECT idcliente FROM tblordenesdeservicio WHERE idorden=".$idOrdSer[$i].")";
			$resulNom=mysql_query($queryNom,$conexion);
			$nom=mysql_fetch_assoc($resulNom);

			$query="SELECT * FROM tblordenesconceptos where idorden=".$idOrdSer[$i];
			if($tipoPlan!="Todos" and $tipoServicio!="Todos")
			{
				$query .=" AND (tipoplan='".$tipoPlan."' and tiposervicio='".$tipoServicio."')";
			}
			if($tipoPlan=="Todos" and $tipoServicio!="Todos")
			{
				$query.=" AND (tipoplan!='".$tipoPlan."' and tiposervicio='".$tipoServicio."')";
			}
			if($tipoPlan!="Todos" and $tipoServicio=="Todos")
			{
				$query.=" AND (tipoplan='".$tipoPlan."' and tiposervicio!='".$tipoServicio."')";
			}
			//echo $query;
			mysql_query("set names 'utf8'",$conexion);
			$resul=mysql_query($query,$conexion)or die(mysql_error());
			while($ordenesConcepto=mysql_fetch_assoc($resul))                
			{
				if($ordFolio["ejecucion"]=="noejecutandose")
		 			$estatus="No ejecutada";
		 		if($ordFolio["ejecucion"]=="ejecutandose")
		 			$estatus="Ejecutada";
		 		if(!empty($ordenesConcepto["idcotconcepto"]) && $ordenesConcepto["idcotconcepto"]!=NULL)
		 		{
		 			$queryCotizaion="SELECT * FROM tblcotizacionconceptos WHERE idcotconcepto=".$ordenesConcepto["idcotconcepto"];
		 			//echo $queryCotizaion;
		 			$resultadoCotizacion=mysql_query($queryCotizaion,$conexion) or die (mysql_error());
			 		while($idCotizacion=mysql_fetch_assoc($resultadoCotizacion))
			 		{
			 			$queryCotizacionEspecifica="SELECT cl.clave_cliente as clave, c.anio,c.ncotizacion FROM tblcotizaciones c LEFT OUTER JOIN tblclientes cl ON c.idcliente = cl.idclientes WHERE c.id=".$idCotizacion["idcotizacion"];
			 			$resultadoCotizacionEspecifica=mysql_query($queryCotizacionEspecifica,$conexion) or die (mysql_error());
			 			while ($cotizacionEspecifica=mysql_fetch_assoc($resultadoCotizacionEspecifica)) 
			 			{
			 				# code...
			 				$folioCotEspecifica .="COT-".$cotizacionEspecifica["clave"]."-".$cotizacionEspecifica["anio"]."-".$cotizacionEspecifica["ncotizacion"]." ";
			 			}
			 			
			 		}
			 		$queryPfEspecifica="SELECT * FROM tblprefacturasconceptos WHERE idordconcepto=".$ordenesConcepto["idordconcepto"];
		 			$resultadoPfEspecifica=mysql_query($queryPfEspecifica,$conexion) or die(mysql_error());
		 			while ($pfEspecifica=mysql_fetch_assoc($resultadoPfEspecifica)) 
		 			{
		 				# code...
		 				$queryPrefacturaEspecifica="SELECT cl.clave_cliente as clave,pf.cfdi,pf.fechacfdi,pf.anio,pf.nprefactura FROM tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.idprefactura=".$pfEspecifica["idprefactura"]." AND pf.estado != 'Cancelada'";
		 				$resultadoPrefactura=mysql_query($queryPrefacturaEspecifica, $conexion) or die (mysql_error());
			 			while($pfEspecifica=mysql_fetch_assoc($resultadoPrefactura))
			 			{
			 				$folioPfEspecifica .="PF-".$pfEspecifica["clave"]."-".$pfEspecifica["anio"]."-".$pfEspecifica["nprefactura"]." ";
			 				$cfdiPfEspecifico .=$pfEspecifica["cfdi"]." ";
			 				$fechaCFDI .= $pfEspecifica["fechacfdi"]." ";
		 				}
		 			}

		 		}
		 		else if(!empty($ordenesConcepto["idpfconcepto"]) && $ordenesConcepto["idpfconcepto"]!= NULL)
		 		{
			 		$queryPrefactura="SELECT * FROM tblprefacturasconceptos WHERE idprefacturaconcepto=".$ordenesConcepto["idpfconcepto"];
			 		//echo $queryPrefactura;
			 		$resultadoPrefactura=mysql_query($queryPrefactura,$conexion) or die (mysql_error());
			 		while($idPrefactura=mysql_fetch_assoc($resultadoPrefactura))
			 		{
			 			//print_r($idPrefactura["idcotizacion"]);
			 			$queryPrefacturaEspecifica="SELECT cl.clave_cliente as clave,pf.cfdi,pf.fechacfdi,pf.anio,pf.nprefactura FROM tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE idprefactura=".$idPrefactura["idprefactura"]." AND pf.estado != 'Cancelada'";
			 			$resultadoPrefactura=mysql_query($queryPrefacturaEspecifica, $conexion) or die (mysql_error());
			 			while($pfEspecifica=mysql_fetch_assoc($resultadoPrefactura))
			 			{
			 				$folioPfEspecifica .="PF-".$pfEspecifica["clave"]."-".$pfEspecifica["anio"]."-".$pfEspecifica["nprefactura"];
			 				$cfdiPfEspecifico .=$pfEspecifica["cfdi"]." ";
			 				$fechaCFDI .= $pfEspecifica["fechacfdi"]." ";
			 			}
			 			if(!empty($idPrefactura["idcotizacion"]))
			 			{
				 			$queryCotEspecififca="SELECT cl.clave_cliente as clave,c.ncotizacion,c.anio FROM tblcotizaciones c LEFT OUTER JOIN tblclientes cl ON c.idcliente = cl.idclientes WHERE c.id=".$idPrefactura["idcotizacion"];
				 			//echo $queryCotEspecififca;
				 			$reltadoCotEspecifica=mysql_query($queryCotEspecififca,$conexion) or die (mysql_error());
				 			while($cotizacionEspecifica=mysql_fetch_assoc($reltadoCotEspecifica))
				 			{
				 				$folioCotEspecifica .="COT-".$cotizacionEspecifica["clave"]."-".$cotizacionEspecifica["anio"]."-".$cotizacionEspecifica["ncotizacion"]." ";
				 			}
			 			}
			 		}
		 		}
		 		foreach ($campos as $campo) 
				{
					switch ($campo) 
					{
						case 'COTIZACIÓN':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $folioCotEspecifica;
							break;
						case 'ORDEN':
							$listaCampos[] = $campo;
							$datosCampos[] = "OS-".$ordFolio["clave"]."-".$ordFolio["anio"]."-".$ordFolio["norden"];
							break;
						case 'PREFACTURA':
							$listaCampos[] = $campo;
							$datosCampos[] = $folioPfEspecifica;
							break;
						case 'CFDI':
							$listaCampos[] = $campo;
							$datosCampos[] = $cfdiPfEspecifico;
							break;
						case 'FECHA DE CFDI':
							$listaCampos[] = $campo;
							$datosCampos[] = $fechaCFDI;
							break;
						case 'ELABORÓ':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = utf8_decode($usuarioElaboro["full_name"]);
							break;	
						case 'CLIENTES':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($nom["razon_soc"]);
							break;
						case 'TIPO DE PLAN':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($ordenesConcepto["tipoplan"]);
							break;
						case 'TIPO DE SERVICIO':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($ordenesConcepto["tiposervicio"]);
							break;
						case 'CANTIDAD':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($ordenesConcepto["cantidad"]);
							break;
						case 'CONCEPTO':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($ordenesConcepto["concepto"]);
							break;
						case 'NOTA':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($ordFolio["servicio"]);
							break;
						case 'P. UNITARIO':
							$listaCampos[] = $campo;
							$datosCampos[] = $ordenesConcepto["precioUnitario"];
						 	break;
						case 'P. TOTAL':
							$listaCampos[] = $campo;
							$datosCampos[] = ($ordenesConcepto["precioUnitario"]*$ordenesConcepto["cantidad"]);
						 	break;
						case 'COMISIÓN ($)':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = (($ordenesConcepto["precioUnitario"]*$ordenesConcepto["cantidad"])*($ordenesConcepto["comision"]/100));
							break;
						case 'COMISIÓN (%)':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $ordenesConcepto["comision"];
							break;
						case 'SUBTOTAL':
							$listaCampos[] = $campo;
							$datosCampos[] = $ordenesConcepto["total"];
							break;
						case 'ESTADO':
							$listaCampos[] = $campo;
							$datosCampos[] = "Ordenes de Servicio ".$ordFolio["estado"];
							break;
						case 'ESTATUS':
							$listaCampos[] = $campo;
							$datosCampos[] = $estatus;
							break;
						case 'DESCUENTO':
							$listaCampos[] = $campo;
							$datosCampos[] = "";
							break;
						case 'MOTIVO DE DESCUENTO':
							$listaCampos[] = $campo;
							$datosCampos[] = "";
							break;
						case 'FECHA INICIAL':
							$listaCampos[] = $campo;
							$datosCampos[] = $ordFolio["fechaInicial"];
							break;
						case 'FECHA FINAL':
							$listaCampos[] = $campo;
							$datosCampos[] = $ordFolio["fechaFinal"];
							break;
						case 'ÚLTIMA MODIFICACIÓN OS':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $ordFolio["elaboracion"];
							break;
						case 'POLIZA':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $ordFolio["numeropoliza"];
							break;
						case 'FOLIO':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $ordFolio["folio"];
							break;	
						default:
							# code...
							break;
					}
				}

				$cont++;
			 	if ($cont==1) 
			 	{
			 		$lista = array ($listaCampos,$datosCampos);
			 	}
			 	else
			 	{
			 		$lista = array ($datosCampos);
			 	}
			 	$out = fopen("php://output", 'w');
				foreach ($lista as $data)
				{
		    		fputcsv($out, $data);
				}
				fclose($out);
				$folioCotEspecifica="";
				$folioPfEspecifica="";
				$cfdiPfEspecifico="";
				$fechaCFDI="";
				$datosCampos = array();

			}		
		}

	} 

	if ($idpFacturas!=[0]) 
	{
		//$cont=0;
		//$idCotOsPf=0;
		$folioCotEspecifica = "";
		$folioOrdEspecifica = "";
		
		for($i=0;$i < sizeof($idpFacturas);$i++)
		{
			$queryFoliopF="SELECT cl.clave_cliente as clave,pf.anio,pf.nprefactura,pf.cfdi,pf.edopago,pf.fechacfdi,pf.realizo,pf.detalle, pf.estado, pf.fechaInicial,pf.descuento,pf.motivodescuento,u.full_name,cl.razon_soc FROM tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes LEFT JOIN tblusuarios u ON u.user_name = pf.realizo WHERE pf.idprefactura = ".$idpFacturas[$i];
			$resulFoliopF= mysql_query($queryFoliopF,$conexion) or die(mysql_error());
			$FoliopF= mysql_fetch_assoc($resulFoliopF);

			$query="SELECT * FROM tblprefacturasconceptos where idprefactura=".$idpFacturas[$i];
				if($tipoPlan!="Todos" and $tipoServicio!="Todos")
			{
				$query .=" AND (tipoplan='".$tipoPlan."' and tiposervicio='".$tipoServicio."')";
			}
			if($tipoPlan=="Todos" and $tipoServicio!="Todos")
			{
				$query.=" AND (tipoplan!='".$tipoPlan."' and tiposervicio='".$tipoServicio."')";
			}
			if($tipoPlan!="Todos" and $tipoServicio=="Todos")
			{
				$query.=" AND (tipoplan='".$tipoPlan."' and tiposervicio!='".$tipoServicio."')";
			}
			mysql_query("set names 'utf8'",$conexion);
			$resul=mysql_query($query,$conexion)or die(mysql_error());
			while($prefactura=mysql_fetch_assoc($resul))                
			{
				if(!empty($prefactura["idcotizacion"]))
				{
					$consulta = "SELECT COUNT(oc.idorden) AS ordenes FROM tblordenesconceptos oc WHERE oc.idpfconcepto = ".$prefactura["idprefacturaconcepto"];
		 			$resultado = mysql_query($consulta,$conexion) or die (mysql_error());
		 			$osExitente = mysql_fetch_assoc($resultado);
		 			if($osExitente["ordenes"] == 0) // No exite OS solo Cotización
		 			{
		 				$consulta = "SELECT CONCAT('COT-',cl.clave_cliente,'-',cot.anio,'-',cot.ncotizacion) as nCotizacion,pc.tipoplan,pc.tiposervicio,pc.cantidad,pc.concepto,pc.precioUnitario,pc.comision FROM tblcotizaciones cot LEFT JOIN tblcotizacionconceptos cc ON cot.id = cc.idcotizacion LEFT JOIN tblclientes cl ON cl.idclientes = cot.idcliente LEFT JOIN tblprefacturasconceptos pc ON pc.idcotizacion = cot.id WHERE cc.idcotizacion = ".$prefactura["idcotizacion"]." AND cc.idcotconcepto = ".$prefactura["idcotconcepto"];
		 			}
		 			else // Exite OS y Cotización
		 			{
		 				$consulta = "SELECT CONCAT('COT-',cl.clave_cliente,'-',cot.anio,'-',cot.ncotizacion) as nCotizacion, CONCAT('OS-',cl.clave_cliente,'-',os.anio,'-',os.norden) AS nOrden,oc.tipoplan,oc.tiposervicio,oc.cantidad,oc.concepto,oc.precioUnitario,oc.comision FROM tblprefacturasconceptos pc LEFT JOIN tblcotizaciones cot ON pc.idcotizacion = cot.id LEFT JOIN tblcotizacionconceptos cc ON cot.id = cc.idcotconcepto LEFT JOIN tblordenesconceptos oc ON oc.idpfconcepto = pc.idprefacturaconcepto LEFT JOIN tblordenesdeservicio os ON os.idorden = oc.idorden LEFT JOIN tblclientes cl ON cl.idclientes = cot.idcliente WHERE pc.idcotizacion = ".$prefactura["idcotizacion"]." AND pc.idcotconcepto = ".$prefactura["idcotconcepto"];
		 			}
		 			$resultado = mysql_query($consulta,$conexion) or die(mysql_error());
		 			while ($datos = mysql_fetch_assoc($resultado)) 
		 			{
		 				$datosEspecificos[] = array_merge($FoliopF,$datos);
		 			}

				}
				else if(!empty($prefactura["idorden"]))
				{
					$consulta = "SELECT CONCAT('COT-',cl.clave_cliente,'-',cot.anio,'-',cot.ncotizacion) as nCotizacion, CONCAT('OS-',cl.clave_cliente,'-',os.anio,'-',os.norden) AS nOrden,oc.tipoplan,oc.tiposervicio,oc.cantidad AS oCantidad,pc.cantidad,oc.concepto,oc.precioUnitario,oc.comision FROM tblordenesdeservicio os LEFT JOIN tblordenesconceptos oc ON os.idorden = oc.idorden LEFT JOIN tblcotizacionconceptos cc ON oc.idcotconcepto = cc.idcotconcepto LEFT JOIN tblcotizaciones cot ON cot.id = cc.idcotizacion LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes LEFT JOIN tblprefacturasconceptos pc ON pc.idorden = os.idorden AND pc.idordconcepto = oc.idordconcepto WHERE oc.idorden = ".$prefactura["idorden"]." AND oc.idordconcepto = ".$prefactura["idordconcepto"]." AND pc.idprefactura = ".$prefactura["idprefactura"];
		 			$resultado = mysql_query($consulta,$conexion) or die(mysql_error());
		 			while ($datos = mysql_fetch_assoc($resultado)) 
		 			{
		 				$datosEspecificos[] = array_merge($FoliopF,$datos);
		 			}

				}
			}
			foreach ($datosEspecificos as $datosReporte) 
	 		{		 			
		 		foreach ($campos as $campo) 
				{
					switch ($campo) 
					{
						case 'COTIZACIÓN':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $datosReporte["nCotizacion"];
							break;
						case 'ORDEN':
							$listaCampos[] = $campo;
							if(isset($datosReporte["nOrden"]))
								$nOrden = $datosReporte["nOrden"]; 
							else 
								$nOrden = "";
							$datosCampos[] = $nOrden;
							break;
						case 'PREFACTURA':
							$listaCampos[] = $campo;
							$datosCampos[] = "PF-".$datosReporte["clave"]."-".$datosReporte["anio"]."-".$datosReporte["nprefactura"];
							break;
						case 'CFDI':
							$listaCampos[] = $campo;
							$datosCampos[] = $datosReporte["cfdi"];
							break;
						case 'FECHA DE CFDI':
							if($datosReporte["fechacfdi"] == "0000-00-00")
								$fechaCfdi = "";
							else
								$fechaCfdi = $datosReporte["fechacfdi"];
							$listaCampos[] = $campo;
							$datosCampos[] = $fechaCfdi;
							break;
						case 'ELABORÓ':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = utf8_decode($datosReporte["full_name"]);
							break;	
						case 'CLIENTES':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($datosReporte["razon_soc"]);
							break;
						case 'TIPO DE PLAN':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($datosReporte["tipoplan"]);
							break;
						case 'TIPO DE SERVICIO':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($datosReporte["tiposervicio"]);
							break;
						case 'CANTIDAD':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($datosReporte["cantidad"]);
							break;
						case 'CONCEPTO':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($datosReporte["concepto"]);
							break;
						case 'NOTA':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($datosReporte["detalle"]);
							break;
						case 'P. UNITARIO':
							$listaCampos[] = $campo;
							$datosCampos[] = $datosReporte["precioUnitario"];
						 	break;
						case 'P. TOTAL':
							$listaCampos[] = $campo;
							$datosCampos[] = ($datosReporte["precioUnitario"]*$datosReporte["cantidad"]);
						 	break;
						case 'COMISIÓN ($)':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = (($datosReporte["precioUnitario"]*$datosReporte["cantidad"])*($datosReporte["comision"]/100));
							break;
						case 'COMISIÓN (%)':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = $datosReporte["comision"];
							break;
						case 'SUBTOTAL':
							$listaCampos[] = $campo;
							$datosCampos[] = ($datosReporte["precioUnitario"]*$datosReporte["cantidad"]) + (($datosReporte["precioUnitario"]*$datosReporte["cantidad"])*($datosReporte["comision"]/100));
							break;
						case 'ESTADO':
							if($datosReporte["estado"] == "Por facturar")
					 			$estado="Prefactura por facturar";
					 		if($datosReporte["estado"] == "Cancelada") 
					 			$estado="Prefactura cancelada";
					 		if($datosReporte["estado"] == "Facturada")
					 			$estado="Prefactura facturada";
							$datosCampos[] = $estado;
							break;
						case 'ESTATUS':
							$listaCampos[] = $campo;
							$datosCampos[] = "";
							break;
						case 'DESCUENTO':
							$listaCampos[] = $campo;
							$datosCampos[] = $datosReporte["descuento"];
							break;
						case 'MOTIVO DE DESCUENTO':
							$listaCampos[] = $campo;
							$datosCampos[] = utf8_decode($datosReporte["motivodescuento"]);
							break;
						case 'FECHA INICIAL':
							$listaCampos[] = $campo;
							$datosCampos[] = $datosReporte["fechaInicial"];
							break;
						case 'FECHA FINAL':
							$listaCampos[] = $campo;
							$datosCampos[] = "";
							break;
						case 'ÚLTIMA MODIFICACIÓN OS':
							$listaCampos[] = utf8_decode($campo);
							$datosCampos[] = "";
							break;
							
						default:
							# code...
							break;
					}
				}
				$cont++;
			 	if ($cont==1) 
			 	{
			 		$lista = array ($listaCampos,$datosCampos);
			 	}
			 	else
			 	{
			 		$lista = array ($datosCampos);
			 	}
			 	$out = fopen("php://output", 'w');
				foreach ($lista as $data)
				{
		    		fputcsv($out, $data);
				}
				fclose($out);
				$arrayCount = 0;
				$listaCampos = array();
				$datosCampos = array();
				$datosEspecificos = array();

			}		
		}
		
	}
	  

	if ($idFacturas!=[0]) 
	{
		$cont = 0;
		$sumCantidad = 0;
		//$idCotOsPf=0;
		$datosCampos = array();
		$datosEspecificos = array();
		
		for($i=0;$i < sizeof($idFacturas);$i++)
		{
			$queryFolioF = "SELECT cl.clave_cliente as clave,pf.anio,pf.nprefactura,pf.cfdi,pf.edopago,pf.fechacfdi,pf.realizo,pf.detalle, pf.estado, pf.fechaInicial,pf.descuento,pf.motivodescuento,u.full_name,cl.razon_soc FROM tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes LEFT JOIN tblusuarios u ON u.user_name = pf.realizo WHERE pf.idprefactura = ".$idFacturas[$i];
			$resulFolioF= mysql_query($queryFolioF,$conexion) or die(mysql_error());
			$FolioF= mysql_fetch_assoc($resulFolioF);

			$query="SELECT * FROM tblprefacturasconceptos where idprefactura=".$idFacturas[$i];
			if($tipoPlan!="Todos" and $tipoServicio!="Todos")
			{
				$query .=" AND (tipoplan='".$tipoPlan."' and tiposervicio='".$tipoServicio."')";
			}
			if($tipoPlan=="Todos" and $tipoServicio!="Todos")
			{
				$query.=" AND (tipoplan!='".$tipoPlan."' and tiposervicio='".$tipoServicio."')";
			}
			if($tipoPlan!="Todos" and $tipoServicio=="Todos")
			{
				$query.=" AND (tipoplan='".$tipoPlan."' and tiposervicio!='".$tipoServicio."')";
			}
			// echo $query;
			mysql_query("set names 'utf8'",$conexion);
			$resul=mysql_query($query,$conexion)or die(mysql_error());
			while($factura=mysql_fetch_assoc($resul))                
			{

		 		if(!empty($factura["idcotizacion"])) // Prefactura anticipada
		 		{
		 			$consulta = "SELECT COUNT(oc.idorden) AS ordenes FROM tblordenesconceptos oc WHERE oc.idpfconcepto = ".$factura["idprefacturaconcepto"];
		 			$resultado = mysql_query($consulta,$conexion) or die (mysql_error());
		 			$osExitente = mysql_fetch_assoc($resultado);
		 			if($osExitente["ordenes"] == 0) // No exite OS solo Cotización
		 			{
		 				$consulta = "SELECT CONCAT('COT-',cl.clave_cliente,'-',cot.anio,'-',cot.ncotizacion) as nCotizacion,pc.tipoplan,pc.tiposervicio,pc.cantidad,pc.concepto,pc.precioUnitario,pc.comision FROM tblcotizaciones cot LEFT JOIN tblcotizacionconceptos cc ON cot.id = cc.idcotizacion LEFT JOIN tblclientes cl ON cl.idclientes = cot.idcliente LEFT JOIN tblprefacturasconceptos pc ON pc.idcotizacion = cot.id WHERE cc.idcotizacion = ".$factura["idcotizacion"]." AND cc.idcotconcepto = ".$factura["idcotconcepto"];
		 			}
		 			else // Exite OS y Cotización
		 			{
		 				$consulta = "SELECT CONCAT('COT-',cl.clave_cliente,'-',cot.anio,'-',cot.ncotizacion) as nCotizacion, CONCAT('OS-',cl.clave_cliente,'-',os.anio,'-',os.norden) AS nOrden,oc.tipoplan,oc.tiposervicio,oc.cantidad,oc.concepto,oc.precioUnitario,oc.comision FROM tblprefacturasconceptos pc LEFT JOIN tblcotizaciones cot ON pc.idcotizacion = cot.id LEFT JOIN tblcotizacionconceptos cc ON cot.id = cc.idcotconcepto LEFT JOIN tblordenesconceptos oc ON oc.idpfconcepto = pc.idprefacturaconcepto LEFT JOIN tblordenesdeservicio os ON os.idorden = oc.idorden LEFT JOIN tblclientes cl ON cl.idclientes = cot.idcliente WHERE pc.idcotizacion = ".$factura["idcotizacion"]." AND pc.idcotconcepto = ".$factura["idcotconcepto"];
		 			}
		 			$resultado = mysql_query($consulta,$conexion) or die(mysql_error());
		 			while ($datos = mysql_fetch_assoc($resultado)) 
		 			{
		 				$nCotizacion = $datos["nCotizacion"];
		 				$sumCantidad += $datos["cantidad"];
		 				$datosEspecificos[] = array_merge($FolioF,$datos);
		 			}
		 			// print_r($datosEspecificos);
		 			$cantidadPf = $factura["cantidad"]-$sumCantidad;
		 			if($cantidadPf > 0)
		 			{	
		 				$datosEspecificos[] = array(
		 					"clave" => $FolioF["clave"],
		 					"anio" => $FolioF["anio"],
		 					"nprefactura" => $FolioF["nprefactura"],
		 					"cfdi" => $FolioF["cfdi"],
		 					"edopago" => $FolioF["edopago"],
		 					"fechacfdi" => $FolioF["fechacfdi"],
		 					"realizo" => $FolioF["realizo"],
		 					"detalle" => $FolioF["detalle"],
		 					"estado" => $FolioF["estado"],
		 					"fechaInicial" => $FolioF["fechaInicial"],
		 					"descuento" => $FolioF["descuento"],
		 					"motivodescuento" => $FolioF["motivodescuento"],
		 					"full_name" => $FolioF["full_name"],
		 					"razon_soc" => $FolioF["razon_soc"],
		 					"nCotizacion" => $nCotizacion,
	 						"nOrden" => '',
	 						"tipoplan" => $factura["tipoplan"],
	 						"tiposervicio" => $factura["tiposervicio"],
	 						"cantidad" => $cantidadPf,
	 						"concepto" => $factura["concepto"],
	 						"precioUnitario" => $factura["precioUnitario"],
	 						"comision" => $factura["comision"]);
		 			}
		 			$sumCantidad = 0;
		 		}
		 		else if(!empty($factura["idorden"])) // ABC
		 		{
		 			$consulta = "SELECT CONCAT('COT-',cl.clave_cliente,'-',cot.anio,'-',cot.ncotizacion) as nCotizacion, CONCAT('OS-',cl.clave_cliente,'-',os.anio,'-',os.norden) AS nOrden,oc.tipoplan,oc.tiposervicio,oc.cantidad AS oCantidad,pc.cantidad,oc.concepto,oc.precioUnitario,oc.comision FROM tblordenesdeservicio os LEFT JOIN tblordenesconceptos oc ON os.idorden = oc.idorden LEFT JOIN tblcotizacionconceptos cc ON oc.idcotconcepto = cc.idcotconcepto LEFT JOIN tblcotizaciones cot ON cot.id = cc.idcotizacion LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes LEFT JOIN tblprefacturasconceptos pc ON pc.idorden = os.idorden AND pc.idordconcepto = oc.idordconcepto WHERE oc.idorden = ".$factura["idorden"]." AND oc.idordconcepto = ".$factura["idordconcepto"]." AND pc.idprefactura = ".$factura["idprefactura"];
		 			$resultado = mysql_query($consulta,$conexion) or die(mysql_error());
		 			while ($datos = mysql_fetch_assoc($resultado)) 
		 			{
		 				$datosEspecificos[] = array_merge($FolioF,$datos);
		 			}

		 		}
			}
		}
		foreach ($datosEspecificos as $datosReporte) 
 		{		 			
	 		foreach ($campos as $campo) 
			{
				switch ($campo) 
				{
					case 'COTIZACIÓN':
						$listaCampos[] = utf8_decode($campo);
						$datosCampos[] = $datosReporte["nCotizacion"];
						break;
					case 'ORDEN':
						$listaCampos[] = $campo;
						if(isset($datosReporte["nOrden"]))
							$nOrden = $datosReporte["nOrden"]; 
						else 
							$nOrden = "";
						$datosCampos[] = $nOrden;
						break;
					case 'PREFACTURA':
						$listaCampos[] = $campo;
						$datosCampos[] = "PF-".$datosReporte["clave"]."-".$datosReporte["anio"]."-".$datosReporte["nprefactura"];
						break;
					case 'CFDI':
						$listaCampos[] = $campo;
						$datosCampos[] = $datosReporte["cfdi"];
						break;
					case 'FECHA DE CFDI':
						$listaCampos[] = $campo;
						$datosCampos[] = $datosReporte["fechacfdi"];
						break;
					case 'ELABORÓ':
						$listaCampos[] = utf8_decode($campo);
						$datosCampos[] = utf8_decode($datosReporte["full_name"]);
						break;	
					case 'CLIENTES':
						$listaCampos[] = $campo;
						$datosCampos[] = utf8_decode($datosReporte["razon_soc"]);
						break;
					case 'TIPO DE PLAN':
						$listaCampos[] = $campo;
						$datosCampos[] = utf8_decode($datosReporte["tipoplan"]);
						break;
					case 'TIPO DE SERVICIO':
						$listaCampos[] = $campo;
						$datosCampos[] = utf8_decode($datosReporte["tiposervicio"]);
						break;
					case 'CANTIDAD':
						$listaCampos[] = $campo;
						$datosCampos[] = utf8_decode($datosReporte["cantidad"]);
						break;
					case 'CONCEPTO':
						$listaCampos[] = $campo;
						$datosCampos[] = utf8_decode($datosReporte["concepto"]);
						break;
					case 'NOTA':
						$listaCampos[] = $campo;
						$datosCampos[] = utf8_decode($datosReporte["detalle"]);
						break;
					case 'P. UNITARIO':
						$listaCampos[] = $campo;
						$datosCampos[] = $datosReporte["precioUnitario"];
					 	break;
					case 'P. TOTAL':
						$listaCampos[] = $campo;
						$datosCampos[] = ($datosReporte["precioUnitario"]*$datosReporte["cantidad"]);
					 	break;
					case 'COMISIÓN ($)':
						$listaCampos[] = utf8_decode($campo);
						$datosCampos[] = (($datosReporte["precioUnitario"]*$datosReporte["cantidad"])*($datosReporte["comision"]/100));
						break;
					case 'COMISIÓN (%)':
						$listaCampos[] = utf8_decode($campo);
						$datosCampos[] = $datosReporte["comision"];
						break;
					case 'SUBTOTAL':
						$listaCampos[] = $campo;
						$datosCampos[] = ($datosReporte["precioUnitario"]*$datosReporte["cantidad"]) + (($datosReporte["precioUnitario"]*$datosReporte["cantidad"])*($datosReporte["comision"]/100));
						break;
					case 'ESTADO':
						if($datosReporte["edopago"] == "nopagado")
				 			$estado="Factura no pagada";
				 		if($datosReporte["edopago"] == "parcialmente") 
				 			$estado="Factura ".$datosReporte["estado"];
				 		if($datosReporte["edopago"] == "pagado")
				 			$estado="Factura pagada";
				 		if($datosReporte["estado"] == "Cancelada")
				 			$estado="Factura cancelada";
						$listaCampos[] = $campo;
						$datosCampos[] = $estado;
						break;
					case 'ESTATUS':
						$listaCampos[] = $campo;
						$datosCampos[] = "";
						break;
					case 'DESCUENTO':
						$listaCampos[] = $campo;
						$datosCampos[] = $datosReporte["descuento"];
						break;
					case 'MOTIVO DE DESCUENTO':
						$listaCampos[] = $campo;
						$datosCampos[] = utf8_decode($datosReporte["motivodescuento"]);
						break;
					case 'FECHA INICIAL':
						$listaCampos[] = $campo;
						$datosCampos[] = $datosReporte["fechaInicial"];
						break;
					case 'FECHA FINAL':
						$listaCampos[] = $campo;
						$datosCampos[] = "";
						break;
					case 'ÚLTIMA MODIFICACIÓN OS':
						$listaCampos[] = utf8_decode($campo);
						$datosCampos[] = "";
						break;
						
					default:
						# code...
						break;
				}
			}
			$cont++;
		 	if ($cont==1) 
		 	{
		 		$lista = array ($listaCampos,$datosCampos);
		 	}
		 	else
		 	{
		 		$lista = array ($datosCampos);
		 	}
		 	$out = fopen("php://output", 'w');
			foreach ($lista as $data)
			{
	    		fputcsv($out, $data);
			}
			fclose($out);
			$arrayCount = 0;
			$listaCampos = array();
			$datosCampos = array();

		}
	 			
		mysql_close($conexion);
	}
	if($cont==0)
	{
		echo "No existe";
	}
//}

?>