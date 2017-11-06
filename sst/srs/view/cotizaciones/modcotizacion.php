<?php
if(!isset($_SESSION['srs_usuario']))
        header('Location: ../view/index.php');
if($datosCotizacion["realizo"] == $_SESSION['srs_usuario'])
{
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
    <title>IntraNet | Spar Todopromo</title>
	<!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <!--Jquery css-->
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <!--Multiselect css-->
    <link rel="stylesheet" href="../css/jquery.multiselect.css">
    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/estilo.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../operaciones">Módulo de Operaciones</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                        	<a href="../controller/crudConceptos.php?accion=listarConceptos"><i class="fa fa-gear fa-fw"></i> Configuraciones</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                        	<a href="../controller/crudIndex.php?urlValue=logout"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="crudCotizaciones.php?accion=listarDatos"><i class="fa fa-plus-circle"></i> Nueva</a>
                        </li>
                        <li>
                            <a style="cursor:pointer;" id="IdbtnModificar"><i class="fa fa-pencil"></i> Modificar</a>
                        </li>

                        <li <?php if(empty($_SESSION['cont'])){ echo "class='habilitar  disabled'"; }?> >
                            <a <?php if (isset($_SESSION['cont']) and $_SESSION['cont']>0) { echo 'onclick=guardarModCotizacion(); style=cursor:pointer;'; }?>  class="IdbtnGuardar" > <i class="fa fa-save"></i> Guardar</a>
                        </li>

                        <li>
                            <a style="cursor:pointer;" id="IdbtnEliminar" name="btnEliminar">
                            	<i class="fa fa-times-circle-o"></i> Eliminar
                            </a>
                        </li>
                        <li>
                            <a href="../controller/crudIndex.php?urlValue=login&principal=1"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
            	<br>
            	<br>
                <div class="col-lg-12">
                    <h1 class="page-header">Modificar cotización</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
            	<div class="form-group col-xs-8 col-lg-12" >
            	<form name="cotizaciones" method="post" action="crudCotizaciones.php?accion=agregarRubroCotizacion">
            		<fieldset <?php if($datosCotizacion["estado"]!="Por autorizar")echo "disabled";?>>
            			<input id="idCotizacion" name="idCotizacionMod" value="<?php echo $_GET['idCotizacion']; ?>" class="hidden"/>
            			<input id="claveClienteModCot" name="clienteModCot" value="<?php echo $datosCotizacion["clave_cliente"]; ?>" class="hidden"/>
                        <input id="idNcotizacion" value="<?php echo $datosCotizacion["ncotizacion"]; ?>" hidden>
            			<div id="lblCot" class="form-group col-xs-12 col-lg-12 text-right " >
            				<strong><?php echo "COT-".$datosCotizacion["clave_cliente"]."-".$datosCotizacion["anio"]."-".$datosCotizacion["ncotizacion"];?></strong>
            			</div>
            			<div class="row">
                      		<div class="form-group col-xs-12 col-lg-7" >
                         		<label>Cliente</label>
                          		<div class="row">
                            		<div class="form-group col-xs-8 col-lg-12" >
                              			<select tabindex="1" class="form-control input-sm Cotizaciones cargarConceptoMod" name="cmbClientes" size="1" id="IdcmbClientes">
                              			<?php 
                                        foreach ($datos as $cliente)
                                        {
                                    	?>
                                            <option class="idCliente" value="<?php echo $cliente['idclientes']; ?>" <?php if($cliente["idclientes"] == $datosCotizacion["idcliente"]) echo "selected"; ?> ><?php echo ($cliente["cliente"]);?></option>
                                    	<?php
                                        }
                                      	?>
                              			</select>
                              		</div>
                            
                          		</div>
                      		</div>
                      		<div class="form-group col-xs-12 col-lg-2">
	                            <label>De</label>
	                            <input tabindex="2" type="date" class="form-control" id="fechaInMod" value="<?php echo $datosCotizacion['fechaInicial'];?>" required="">
                        	</div>
                        	<div class="form-group col-xs-12 col-lg-2">
	                            <label>Hasta</label>
	                            <input tabindex="3" type="date" class="form-control" id="fechaFinMod" value="<?php echo $datosCotizacion['fechaFinal'];?>" required="">
                        	</div>
                       	</div>

                        <div class="row">
	                        <div class="form-group col-xs-12 col-lg-11">
	                            <label >Servicio</label>         
	                            <textarea tabindex="4" class="form-control datosTextMod" name="txtServicio" id="IdtxtServicio" style="resize:none;" title='Se necesita digitar un servicio' required><?php echo $datosCotizacion["servicio"];?></textarea>
	                        </div>
                    	</div>

                    	<div class="row">
                    	<div class="form-group col-xs-12 col-lg-6">
                    		<label >Tipo de plan</label>        
                            <select tabindex="5" class="form-control datosTextMod" name="cmbTipoPlan" id="IdcmbTipoPlan" required >
                            	<option disabled selected value="">--- Seleccione Tipo de plan ---</option>
                            	<?php
                            	foreach ($arrayTipoPlan as $tipoPlan) 
                            	{
                            	?>
									<option><?php echo $tipoPlan;?></option>
                            	<?php
                            	}
                            	?>
                            </select>
                    	</div>

                    	<div class="form-group col-xs-12 col-lg-5" >
                    		<label >Tipo de servicio</label>
                    		<select tabindex="6" class="form-control datosTextMod cargarConceptoMod" name="cmbTipoServicio" id="IdcmbTipoServicio" required>
                    			<option disabled selected value="">--- Seleccione Tipo de servicio ---</option>
								<?php 
								$i=0;
								foreach ($arrayTipoServicio as $tipoServicio) 
								{
								?>
									<option data-toggle='tooltip'  data-placement='top' title="Ejemplo: <?php echo $arrayAyuda[$i];?>" ><?php echo $tipoServicio;?></option>
								<?php
								$i++;
								}
								?>
                    		</select>
                    	</div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-6 col-lg-2" >
                            <label >Cantidad</label>               
                            <input tabindex="7" type="number" min="1" class="form-control" style="text-align:right" name="txtCantidad" id="IdtxtCantidad" required title="Se necesita una cantidad">
                        </div>
                        <div class="form-group col-xs-6 col-lg-3" >
                            <label >Concepto</label>                         
                            <select tabindex="8" class="form-control Cotizaciones" name="cmbTipoConcepto"  id="IdcmbTipoConcepto" required title="Se necesita un concepto">
                            
                            </select>
                        </div>
                       
                        <div class="form-group col-xs-6 col-lg-2" >
                            <label >Precio unitario</label>
                            <div class="input-group">
                            <span class='input-group-addon'>$</span><input tabindex="9" type="number" class="form-control" style="text-align:right" step="0.01" min="0.01" id="IdtxtPUnitario" style="resize:none;" name="txtPUnitario" value="" tabindex="8" required title="Se necesita un precio unitario">
                            </div>
                        </div>
                         <div class="form-group col-xs-6 col-lg-2" >
                            <label>Comisión</label>
                            <div class="input-group">
                              <input tabindex="10" type="number" style="text-align:right" step="0.01" min="0.00" class="form-control"  name="txtComisionAgencia" id="IdtxtComisionAgencia" ><span class='input-group-addon'>%</span>
                            </div>
                        </div>
                        <div class="form-group col-xs-6 col-lg-2" >
                            <label>Subtotal</label>
                            <input type="text" class="form-control" style="text-align:right" name="txtSubtotal" id="IdtxtSubTotal1" readonly>
                        </div>
                        <div class="form-group col-xs-6 col-lg-1 text-center" >
                            <br>
                            <input tabindex="11" id="IdbtnAgregar" type="submit" value="Agregar" name="btnAgregar"  class="btn btn-primary input-sm">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-6   col-lg-5  text-center" >
                            <label id="IdlblDescripcionConcepto" style="display:none" name="lblDescripcionConcepto">Descripcion del concepto</label>
                            <textarea type="text" class="form-control hidden descripcionConcepto" tyle="" name="txtDescripcionConcepto" id="IdtxtDescripcionConcepto" ></textarea>
                        </div>
                    </div>
	
            		</fieldset>
            	</form>

            		<form id="IdGuardar" name="eliminarCotizaciones" method="post" action="guardarcotagregada.php">
         				<div id="IdtxtCotizacion" name="txtCotizacion" value="" class="form-group col-xs-12 col-lg-12">
            				<table id="Idtabla"  style="width:100%; "  cellpadding="10">
	               				<thead >
	               				</thead>
	               				<tbody>

               					<!--Carga los datos del cliente y se muestran en la tabla-->

	               				<?php
                                if(isset($filaConceptosCot))
                                {
    	                			$i=1;
    	                			foreach($filaConceptosCot as $filaConceptosCot)                
    	                			{ 
    	                   				//$_SESSION['numcot']=$_SESSION['numcot']+1;
    	                  
    	                        		echo "
    			                        <tr style='border-bottom: 0px;'>
    			                        <td align='center' class='col-xs-6 col-lg-3 TipoPlan'> <b>TIPO DE PLAN</b></td>
    			                        <td class='col-xs-6 col-lg-5 TipoServicio'> <b>TIPO DE SERVICIO</b></td>
    			                        <th class='col-xs-6 col-lg-1'> <b></b></th>
    			                        <th class='col-xs-6 col-lg-1'> <b></b></th>
    			                        <th class='col-xs-6 col-lg-1'> <b></b></th>
    			                        </tr>

    			                        <tr align='justify'>
    			                        <td class='col-xs-6 col-lg-3'>".$filaConceptosCot['tipoplan']."</td>
    			                        <td class='col-xs-6 col-lg-5'align='left'>".$filaConceptosCot['tiposervicio']."</td>
    			                        </tr>
    			                        

    			                        <tr >
    			                        <td align='center' class='col-xs-6 col-lg-1 Cantidad'> <b>Cantidad</b></td>
    			                        <td align='left' class='col-xs-6 col-lg-5 Concepto'> <b>Concepto</b></td>
    			                        <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Unitario</b> </td>
    			                        <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Total</b> </td>
    			                        <td align='center'  class='col-xs-6 col-lg-2 PUnitario'> <b>Comisión</b></td>
    			                        <td align='center' class='col-xs-6 col-lg-2 SubTotal'> <b>Sub_Total</b></td>
    			                        <td align='center' class='col-xs-6 col-lg-1 Editar ";
    	                        		if($datosCotizacion["realizo"] == $_SESSION['srs_usuario'] || $datosCotizacion["realizo"] == "")
    	                          		{ 
    	                              		if($datosCotizacion["estado"]=="Autorizada" || $datosCotizacion["estado"]=="Cancelada" || $datosCotizacion["estado"]=="Cerrada") 
    	                                	echo " hidden"; 
    	                          		}
    	                          		else
    	                          		{
    	                            		echo "hidden";

    	                          		}
    	                        		echo "';> 
    			                        <b class='btnEditar'>Editar</b><b class='btnEliminar' hidden>Eliminar</b></td>
    			                        </tr>
    			                      
    			                         
    			                        <tr align='center' class='filaRubro'>
    			                        <td align='center' class='col-xs-6 col-lg-1'>".$filaConceptosCot['cant']."</td>
    			                        <td align='left'   class='col-xs-6 col-lg-5' value='".$filaConceptosCot['idconcepto']."#".$filaConceptosCot['concepto']."'>".$filaConceptosCot['concepto']."</td>
    			                        <td align='center' class='col-xs-6 col-lg-2'>$ ".number_format($filaConceptosCot['precio'],2)."</td>
    			                        <td align='center' class='col-xs-6 col-lg-2'>$ ".number_format($filaConceptosCot['preciototal'],2)."</td>
    			                        <td align='center' data-original-title='".$filaConceptosCot['comisionagencia']."'><a  class='tool' data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='".$filaConceptosCot['comisionagencia']."%'>$ ".number_format($filaConceptosCot['comision'],2)."</a></td>
    			                        <td>$ ".number_format($filaConceptosCot['total'],2)."</td>
    			                        <td";
    			                        if($datosCotizacion["realizo"] == $_SESSION['srs_usuario'] || $datosCotizacion["realizo"] == "")
    			                        {
    			                            if($datosCotizacion["estado"]=="Autorizada" || $datosCotizacion["estado"]=="Cancelada" || $datosCotizacion["estado"]=="Cerrada") 
    			                              echo " hidden"; 
    			                        }
    			                        else
    			                        {
    			                            echo " hidden";
    			                        }
    	                          
    			                        echo">
    			                        <a href='#modalEditarCotizacion' class='imgEditar' data-toggle='modal'><img src='../img/btn_editar.gif'></a>
    			                        <a style='cursor:pointer;' class='imgEliminar' value='".$filaConceptosCot['idcotconcepto']."' hidden><img src='../img/imgEliminar.gif'></a>
    			                        </td>
    			                        
    			                        <td class='hidden'>".$filaConceptosCot['idcotconcepto']."</td>
    			                        </tr>
    			                        
    			                        <tr align='left' class='filaRubro'><td></td><td class='col-xs-6 col-lg-5' >".$filaConceptosCot['descrip']."</td></tr>
    			                        <tr><td><br></td></tr>
    			                        ";
    	                       		}
                                }

	                  			/////////// Se cargan a la tabla los datos que se agregan/////////////

	                  			if (isset($_SESSION['cont']) and $_SESSION['cont']!="") 
	                  			{
	                     
				                    for($i=1;$i<=$_SESSION['cont'];$i++) 
				                    {
	                        
				                        echo "
				                        <tr style='border-bottom: 0px;'>
				                        <td align='center' class='col-xs-6 col-lg-3 TipoPlan'> <b>TIPO DE PLAN</b></td>
				                        <td class='col-xs-6 col-lg-5 TipoServicio'> <b>TIPO DE SERVICIO</b></td>
				                        <th class='col-xs-6 col-lg-1'> <b></b></th>
				                        <th class='col-xs-6 col-lg-1'> <b></b></th>
				                        <th class='col-xs-6 col-lg-1'> <b></b></th>
				                        </tr>

				                        <tr align='center'>
				                        <td class='col-xs-6 col-lg-3'>".$_SESSION['cmbTipoPlanMod'][$i]."</td>
				                        <td class='col-xs-6 col-lg-5'align='left'>".$_SESSION['cmbTipoServicioMod'][$i]."</td>
				                        </tr>

				                        <tr>
				                        <td align='center' class='col-xs-6 col-lg-1 Cantidad'> <b>Cantidad</b></td>
				                        <td align='left' class='col-xs-6 col-lg-5 Concepto'> <b>Concepto</b></td>
				                        <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Unitario</b> </td>
				                        <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Total</b> </td>
				                        <td align='center'  class='col-xs-6 col-lg-2 PUnitario'> <b>Comisión</b></td>
				                        <td align='center' class='col-xs-6 col-lg-2 SubTotal'> <b>Sub_Total</b></td>
				                        <td align='center' class='col-xs-6 col-lg-1 Editar'> 
				                        <b>Eliminar</b></td>
				                        </tr>

				                        <tr align='center' class='filaRubro'>
				                        <td align='center' class='col-xs-6 col-lg-1'>".$_SESSION['txtCantidadMod'][$i]."</td>
				                        <td align='left' class='col-xs-6 col-lg-5'>".$_SESSION['cmbTipoConceptoMod'][$i]."</td>
				                        <td align='center' class='col-xs-6 col-lg-2'>$ ".$_SESSION['txtPUnitarioMostrarMod'][$i]."</td>
				                        <td align='center' class='col-xs-6 col-lg-2'>$ ".number_format($_SESSION["precioTotalMod"][$i],2)."</td>
				                        <td align='center'  ><a data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='".$_SESSION['txtComisionAgenciaModm'][$i]."%'>";
				                        if ($_SESSION['txtComisionAgenciaMod'][$i]>"0" || $_SESSION['txtComisionAgenciaMod'][$i]=="0") 
				                        {
				                          echo "$ ".number_format($_SESSION['txtComisionAgenciaMod'][$i],2);
				                        }
				                        else
				                          echo "$ 0";

				                        echo "</a></td>
				                        <td>$ ".$_SESSION['subTotalMostrarMod'][$i]."</td>
				                        <td><a href='crudCotizaciones.php?accion=eliminarRubroCotizacion&idCotizacion=".$_GET['idCotizacion']."&value=".$i."' ><img src='../img/imgEliminar.gif'></a></td>
				                        
				                        </tr>
				                        <tr class='filaRubro'><td></td><td class='col-xs-6 col-lg-5'>".$_SESSION['txtDescripcionConceptoMod'][$i]."</td></tr>
				                        <tr><td><br></td></tr>";
	                     			}
	                  			}
	                  			?>
            					</tbody>
            
         					</table>
      					</div>
                  		<br/><br/>
                  
		                <div id="IdtxtCantidadLetra1" class="form-group col-xs-12 col-lg-8">
		                    <label>Importe con número y letra</label>
		                    <textarea type="text" id="IdtxtCantidadLetra" class="form-control" name="txtCantidadLetra" rows="4" style="resize:none;" value="" readonly="">
		                    </textarea>
		                </div>

                  		<div id="IdlblSubtotal" class="form-group col-xs-12 col-lg-2 text-right">
	                  		<br/>
	                  		<label>Subtotal </label>
                  		</div>
		                  <!--Calcula el subtotal, el iva, el total y carga los datos en los textbox-->
		                  <?php
		              
		                    // $query="SELECT SUM(total) as subtotal FROM tblcotizacionconceptos where idcotizacion='".$_SESSION['id']."'";                     
		                    // $resul=mysql_query($query,$conexion)or die(mysql_error());
		                    // while($sumacot=mysql_fetch_assoc($resul))                
		                    // { 
		                     
		                    //   if(isset($_SESSION['cont']) and $_SESSION['cont']==0)
		                    //   {
		                    //     $_SESSION['subTotal2Mod']=$sumacot['subtotal'];
		                    //     $_SESSION["ivaMod"]=$_SESSION['subTotal2Mod']*.16;
		                    //     $_SESSION["total2Mod"]=$_SESSION['subTotal2Mod']+$_SESSION["ivaMod"];

		                    //   }
		                      
		                    // }

		                  ?>
                  		<div id="IdtxtSubTotal1" class="form-group col-xs-12 col-lg-2">
                  			<br/>
                        	<input type="text" id="IdtxtSubTotal"  style="text-align: right" class="form-control" name="txtSubTotal" value="<?php echo "$ ".number_format($totalFinal,2);?>" readonly="">
                  		</div>

		                <div id="IdlblIva" class="form-group col-xs-12 col-lg-2 text-right">
		                    <label>IVA 16% </label>
		                </div>

                  		<div id="IdtxtIva1" class="form-group col-xs-12 col-lg-2">
                     		<input type="text" id="IdtxtIva"  style="text-align: right" class="form-control" name="txtIva" value="<?php echo "$ ".number_format($totalIva,2);?>" readonly="">
                  		</div>

                  		<div id="IdlblTotal" class="form-group col-xs-12 col-lg-2 text-right">
                     		<label>Total </label>
                  		</div>

                  		<div id="IdtxtTotal1" class="form-group col-xs-12 col-lg-2">
                     		<input type="text" id="IdtxtTotal"  style="text-align: right" class="form-control" name="txtTotal" value="<?php echo "$ ".number_format($totalFIva,2);?>" readonly="">
                  		</div>
		                <div class="form-group col-xs-12 col-lg-12">
		                    <br>
		                </div>
                  
 				</form>
					
				
				<!--Modal para editar los datos de una cotizacion-->
 				<form id='formModal' action="crudCotizaciones.php?accion=guardarModificacionModal" method="post">
 					<input id="idCotizacion" name="idCotizacionModal" value="<?php echo $_GET['idCotizacion']; ?>" class="hidden"/>
					<div class="modal fade" id="modalEditarCotizacion" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        				<div class="modal-dialog modal-lg">
          					<div class="modal-content">
            					<div class="modal-header">
              						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              						<h4 class="modal-title" id="IdmodalLabel"><b>Modificar cotización</b></h4>
            					</div>
            				<div class="modal-body ">
            					<fieldset>
            					<legend>1. Generar modificación</legend>
                  				<div class="row">
                    				<div class="col-xs-6 col-lg-2">
                      					<input type="text" id="IdCot" name="IdCotMod" hidden>
                    				</div>
			                    	<!-- <div class="col-xs-6 col-lg-2">
			                      		<input type="text" id="IdsubTotal" name="subTotal" value="<?php echo $_SESSION['total2Mod'] ?>" hidden>
			                    	</div> -->
                  				</div>
                  
				                <div class="row">
				                    <div class="form-group col-lg-offset-1 col-lg-4">
				                    <b>Tipo de plan:</b> 
				                    </div>
				                    <div class="form-group col-lg-4">
				                    <b>Tipo de servicio:</b>
				                    </div>
				                </div>                  
                 
                  				<div class="row">
                       				<div class="form-group col-xs-6 col-lg-offset-1 col-lg-4">
                          				<select  class="form-control " name="cmbTipoPlanModal" size="1" id="IdcmbTipoPlanModal" required >
                              				<option disabled selected value="">--- Seleccione ---</option>
			                            <!--Carga el tipo de plan en el combo-->
			                            <?php
			                              $arraytipoplan = array('Promotoría o Merchandiser','Demostración o Impulso de Ventas', 'Administración de nómina'); 
			                                for ($i=0; $i < 3 ; $i++) 
			                                { 
			                                  echo "<option>".$arraytipoplan[$i]."</option>";
			                                }
			                            ?>
                          				</select>
                        			</div> 
                        
                      
                        			<div class='form-group col-xs-6 col-lg-4'>
                        				<select  class="form-control" name="cmbTipoServicioModal" size="1" id="IdcmbTipoServicioModal"  required>
                            				<option disabled selected value="">--- Seleccione ---</option>
                            				<!--Carga el tipo de servicio en el combo-->
				                            <?php  
				                            $arraytiposervicio = array('Gestión de personal (Nómina)','Compras de Bienes o Servicios', 'Coordinación y/o Consultoría','Gastos y/o Viáticos');
				                              for ($i=0; $i < 4 ; $i++) 
				                              { 
				                                 
				                                  echo "<option>".$arraytiposervicio[$i]."</option>";
				                              }
				                            ?>
                          				</select>
                        			</div>
                    			</div>                      
                      
                      			<div class="row">
                        			<div class='form-group col-xs-6 col-lg-offset-1 col-lg-4'>
                          				<b>Concepto:</b>
                        			</div>
                        			<div class='form-group col-xs-6 col-lg-4'>
                          				<b>Descripción del concepto:</b>
                        			</div>
                      			</div>

                      			<div class="row">
                        			<div class='form-group col-xs-6 col-lg-offset-1 col-lg-4'>
                            			<select  class="form-control" name="cmbTipoConceptoModal" size="1" id="IdcmbTipoConceptoModal" required>
                               				<option disabled selected value="">--- Seleccione ---</option>
                            			</select>
                        			</div>

                        			<div class='form-group col-xs-6 col-lg-6'>
                          				<textarea  type="text" class="form-control" style="resize:none;" name="txtDescripcionConceptoModal" id="IdtxtDescripcionConceptoModal"></textarea>
                        			</div>
                      			</div>
                   
                        		<div class="row">
		                           	<div class="form-group col-lg-offset-1 col-lg-2">
		                           		<b>Cantidad:</b>
		                           	</div>
		                           	<div class='form-group col-xs-6 col-lg-3'>
		                           		<b>Precio unitario:</b>
		                           	</div>
		                           	<div class='form-group col-xs-6 col-lg-2'>
		                           		<b>Comision:</b>
		                           	</div>
		                           	<div class='form-group col-xs-6 col-lg-2'>
		                           		<b>Subtotal:</b>
		                           	</div>
                        		</div>

                        		<div class="row">
                          			<div class='col-xs-6 col-lg-offset-1 col-lg-2'>
                            			<input  type="number" min="1" class="form-control" style="text-align:right" name="txtCantidadModal" id="IdtxtCantidadModal" required="" title="Se necesita una cantidad">
                          			</div>
                          
                          			<div class='col-xs-6 col-lg-3'>
                            			<div class="input-group">
                            				<span class="input-group-addon">$</span><input  type="number" class="form-control" style="text-align:right" step="0.01" min="0.01" name="txtPUnitarioModal" id="IdtxtPUnitarioModal"  value="" required="" title="Se necesita un precio unitario">
                            			</div>
                          			</div>
                      
                          			<div class='col-xs-6 col-lg-2'>
                            			<div class="input-group">
                            				<input  type="number" style="text-align:right" step="0.01" min="0.00" class="form-control" name="txtComisionAgenciaModal" id="IdtxtComisionAgenciaModal"><span class="input-group-addon">%</span>
                            			</div>
                          			</div>
                      
                          			<div class='col-xs-6 col-lg-3'>
                          				<div class="input-group">
                            				<span class="input-group-addon">$</span><input type="text" class="form-control" style="text-align:right" name="txtSubtotalModal" id="IdtxtSubTotalModal" readonly=""><span class="input-group-addon">M/N</span>
                          				</div>
                        			</div>
                        		</div>
                        
                				<br>
                				</fieldset>
                				<div id="mensaje"></div>
                				<div class="modal-footer">
                  					<button  type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  					<input  type="submit" id="guardarModal" class="btn btn-primary IdbtnGuardar" value="Guardar"/>
                				</div>
            				</div>
          				</div>
        			</div>
      			</div>
 			</form>

 				
 				 <!--Dialogo Jquery UI-->
				<div id="confirmacion" title="Aviso" style="display:none">
				 	<p><span class="glyphicon glyphicon-warning-sign" style="float:left; margin:0 7px 50px ;"></span>¿Estás seguro de eliminar el registro?</p>
				</div>

            	</div>
            </div><!-- /.row -->
        </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>
     <!-- Ui jQuery-->
    <script src="../js/jquery-ui.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../js/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>
    <script src="../js/cotizaciones/indexcotizaciones.js"></script>
    <script src="../js/cotizaciones/modalmodificar.js"></script>
</body>
</html>

<?php
}
else
    header('location:../view');
?>
