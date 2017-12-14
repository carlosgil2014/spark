<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: ../../index.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
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
    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="loader">  
        <label class="cargando" >CARGANDO...</label>
    </div>
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
                <a class="navbar-brand" href="../../">Módulo de Operaciones</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
            <li><a ><?php echo $nombre;?></a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <img src="../img/user.png" class="imgUser" style="width: 27px; height: 27px;">  <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="crudConceptos.php?accion=listarConceptos"><i class="fa fa-gear fa-fw"></i> Configuraciones</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="crudIndex.php?urlValue=logout"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
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
                        <!-- <li><a href="#"><i class="fa fa-plus-circle"></i> Nueva</a></li> -->
                        <li <?php if(empty($_SESSION["contador"])) echo "class='disabled'";?> id="idDisabled">
                            <a  <?php if(!empty($_SESSION["contador"])) echo " style='cursor:pointer;' onclick='guardarCotizacion();'";?> id="IdbtnGuardar" > <i class="fa fa-save"></i> Guardar</a>
                        </li>
                        <li><a href="../"><i class="fa fa-arrow-circle-left"></i> Regresar</a></li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-default sidebar -->
        </nav>
        <!-- /.navbar-fixed-top -->
		
		<div id="page-wrapper">

			<div class="row">
	            <br>
	            <br>
                <div class="col-lg-12">
                    <h1 class="page-header">Nueva cotización </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

			<div class="row">
				<div class="form-group col-xs-8 col-lg-12" >	
					<div class="row">
	                    <div class="form-group col-xs-12 col-lg-7" >
	                        <label>Cliente</label>
	                        <div class="row">
	                            <div class="form-group col-xs-8 col-lg-12" >
	                            <div class="tmp1"></div>
	                            <div class="tmp2"></div>
	                            <form name="cotizaciones" method="post" action="crudCotizaciones.php?accion=agregarCotizacion">
	                              <select tabindex="1" class="form-control input-sm datosText cargarConcepto" name="cmbClientes" id="IdcmbClientes" size="1"required>
	                              <option disabled selected value="">--- Seleccione Cliente---</option>
	                              	<?php 
                                        foreach ($datos as $cliente)
                                        {
                                    ?>
                                            <option class="idCliente" value="<?php echo $cliente['cliente']."#".$cliente['idclientes']; ?>" <?php if(isset($_SESSION["idCliente"]) && $_SESSION["idCliente"] == $cliente["idclientes"]) echo "selected"; ?> ><?php echo ($cliente["cliente"]);?></option>
                                    <?php
                                        }
                                      ?>
	                              </select>
	                            </div>
	                        </div>
	                    </div>
	                    
	                    <div class="form-group col-xs-12 col-lg-2">
	                        <label>De</label>
	                        <input tabindex="2" type="date" class="form-control datosText" name="fInicial" id="fechaIn" value="<?php if(isset($_SESSION["fechaInicial"])){echo $_SESSION["fechaInicial"];}else{ echo date("Y-m-d");}?>" required="">
	                    </div>
	                    <div class="form-group col-xs-12 col-lg-2">
	                        <label>Hasta</label>
	                        <input tabindex="3" type="date" class="form-control datosText" name="fFinal" id="fechaFin" value="<?php if(isset($_SESSION["fechaFinal"]))echo$_SESSION["fechaFinal"];else echo date("Y-m-d");?>" required="">
	                    </div>
	                </div>

	                <div class="row">
                        <div class="form-group col-xs-12 col-lg-11">
                            <label >Servicio</label>         
                            <textarea tabindex="4" class="form-control datosText" name="txtServicio" id="IdtxtServicio" style="resize:none;" title='Se necesita digitar un servicio' required><?php if(isset($_SESSION["servicio"])) echo$_SESSION["servicio"];?></textarea>
                        </div>
                    </div>

                    <div class="row">
                    	<div class="form-group col-xs-12 col-lg-6">
                    		<label >Tipo de plan</label>        
                            <select tabindex="5" class="form-control datosText" name="cmbTipoPlan" id="IdcmbTipoPlan" required >
                            	<option disabled selected value="">--- Seleccione Tipo de plan ---</option>
                            	<?php
                            	foreach ($arrayTipoPlan as $tipoPlan) 
                            	{
                            	?>
									<option <?php if(isset($_SESSION["tipoPLan"]) && $_SESSION["tipoPLan"] == $tipoPlan) echo"selected";?>><?php echo $tipoPlan;?></option>
                            	<?php
                            	}
                            	?>
                            </select>
                    	</div>

                    	<div class="form-group col-xs-12 col-lg-5" >
                    		<label >Tipo de servicio</label>
                    		<select tabindex="6" class="form-control datosText cargarConcepto" name="cmbTipoServicio" id="IdcmbTipoServicio" required>
                    			<option disabled selected value="">--- Seleccione Tipo de servicio ---</option>
								<?php 
								$i=0;
								foreach ($arrayTipoServicio as $tipoServicio) 
								{
								?>
									<option data-toggle='tooltip'  data-placement='top' title="Ejemplo: <?php echo $arrayAyuda[$i];?>" <?php if(isset($_SESSION["tipoServicio"]) && $_SESSION["tipoServicio"] == $tipoServicio) echo "selected"?>><?php echo $tipoServicio;?></option>
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
                            <input tabindex="7" type="number" min="1" class="form-control text-right" name="txtCantidad" id="IdtxtCantidad" title="Se necesita una cantidad" required>
                        </div>

						<div class="form-group col-xs-6 col-lg-3" >
                            <label >Concepto</label>                         
                            <select tabindex="8" class="form-control" name="cmbTipoConcepto" id="IdcmbTipoConcepto" required>
                            	<option hidden selected value="">--- Seleccione Concepto ---</option>
                            	<?php
                            	foreach ($datosConceptos as $conceptos) 
                            	{
                            	?>
                            		<option value="<?php echo $conceptos["id"]."#".$conceptos['nombreRubro'];?>" ><?php  echo  $conceptos['nombreRubro'];?></option>
                            	<?php
                            	}
                            	?>
                            	
                            </select>
                        </div>

                        <div class="form-group col-xs-6 col-lg-2" >
                            <label >Precio unitario</label>
                            <div class="input-group">
                            <span class='input-group-addon'>$</span><input tabindex="9" type="number" class="form-control text-right" name="txtPUnitario" id="IdtxtPUnitario" value="" step="0.01" min="0.01"  title="Se necesita un precio unitario" required>
                            </div>
                        </div>

                        <div class="form-group col-xs-6 col-lg-2" >
                            <label>Comisión</label>
                            <div class="input-group">
                              <input tabindex="10" type="number" class="form-control text-right" name="txtComisionAgencia" id="IdtxtComisionAgencia" step="0.01" min="0.00"><span class='input-group-addon'>%</span>
                            </div>
                        </div>

                        <div class="form-group col-xs-6 col-lg-2" >
                            <label>Subtotal</label>
                            <input type="text" class="form-control text-right" name="txtSubtotal" id="IdtxtSubTotal1" readonly>
                        </div>

                        <div class="form-group col-xs-6 col-lg-1 text-center" >
                            <br>
                            <input tabindex="11" type="submit" class="btn btn-primary input-sm" name="btnAgregar" id="IdbtnAgregar" value="Agregar" >
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-xs-6 col-lg-5 text-center descripcionConcepto hidden">
                            <label name="lblDescripcionConcepto" id="IdlblDescripcionConcepto">Descripción del concepto</label>
                            <textarea type="text" class="form-control" name="txtDescripcionConcepto" id="IdtxtDescripcionConcepto" ></textarea>
                        </div>
                    </div>
                    </form>

                    <div id="IdtxtCotizacion" name="txtCotizacion" value="" class="form-group col-xs-12 col-lg-12">

          				<!--Carga los datos de una cotizacion agregada-->
				        <?php 
				        if (isset($_SESSION['contador']) and $_SESSION['contador']>0) 
				        {
				         ?>
				            <table id="tabla"  style="width:100%; "  cellpadding="10">
				               <thead >
				                
				               <?php
				                  if (isset($_SESSION['contador']) and $_SESSION['contador']!="") 
				                  {
				                     # code...
				                     for($i=1;$i<=$_SESSION['contador'];$i++) 
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
				                        <td class='col-xs-6 col-lg-3'>".$_SESSION['cmbTipoPlan'][$i]."</td>
				                        <td class='col-xs-6 col-lg-5'align='left'>".$_SESSION['cmbTipoServicio'][$i]."</td>
				                        </tr>

				                        <tr >
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
				                        <td align='center' class='col-xs-6 col-lg-1'>".$_SESSION['txtCantidad'][$i]."</td>
				                        <td align='left' class='col-xs-6 col-lg-5'>".$_SESSION['cmbTipoConcepto'][$i]."</td>
				                        <td align='center' class='col-xs-6 col-lg-2'>$ ".$_SESSION['txtPUnitarioMostrar'][$i]."</td>
				                        <td align='center' class='col-xs-6 col-lg-2'>$ ".number_format($_SESSION["precioTotal"][$i],2)."</td>
				                        <td align='center'><a style='color:black; text-decoration:none;' data-toggle='tooltip'  data-placement='bottom' title='".$_SESSION['txtComisionAgenciaM'][$i]."%'>";
				                        if ($_SESSION['txtComisionAgencia'][$i]>"0" || $_SESSION['txtComisionAgencia'][$i]=="0") 
				                        {
				                          echo "$ ".number_format($_SESSION['txtComisionAgencia'][$i],2);
				                        }
				                        else
				                          echo "$ 0";

				                        echo "</a></td>
				                        
				                        <td>$ ".$_SESSION['subTotalMostrar'][$i]."</td>
				                        <td><a href='crudCotizaciones.php?accion=eliminarRubro&value=".$i."' ><img src='../img/imgEliminar.gif'></a></td>
				                        </tr>
				                        <tr  class='filaRubro'><td></td><td class='col-xs-6 col-lg-5'>".$_SESSION['txtDescripcionConcepto'][$i]."</td></tr>
				                        <tr><td><br></td></tr>";
				                     }
				                  }
				                  ?>

				            	</thead>
				         	</table>
				        <?php
				        }
				        ?>
      				</div>
					
					<br/><br/>
					<div class="row">
		                <div id="IdtxtCantidadLetra1" class="form-group col-xs-12 col-lg-8">
		                	<label>Importe con número y letra</label>
		                   	<textarea type="text" class="form-control" name="txtCantidadLetra" id="IdtxtCantidadLetra" rows="4" style="resize:none;" value="" readonly="">
		                   	</textarea>
		                </div>

		                <div id="IdlblSubtotal" class="form-group col-xs-12 col-lg-2 text-right">
	                        <br/>
	                        <label>Subtotal </label>
		                </div>

		                <div id="IdtxtSubTotal1" class="form-group col-xs-12 col-lg-2">
		                    <br/> 
		                    <input type="text" class="form-control text-right" name="txtSubTotal" id="IdtxtSubTotal" value="<?php if(isset($_SESSION["subTotal2Mostrar"]))echo "$ ".$_SESSION["subTotal2Mostrar"];?>"  readonly="">
		                </div>

		                <div id="IdlblIva" class="form-group col-xs-12 col-lg-2 text-right">
		                    <label>IVA 16% </label>
		                </div>

		                <div id="IdtxtIva1" class="form-group col-xs-12 col-lg-2">
		                    <input type="text" class="form-control text-right" name="txtIva" id="IdtxtIva" value="<?php if(isset($_SESSION["ivaMostrar"]))echo "$ ".$_SESSION["ivaMostrar"];?>" readonly="">
		                </div>

		                <div id="IdlblTotal" class="form-group col-xs-12 col-lg-2 text-right">
		                    <label>Total </label>
		                </div>

		                <div id="IdtxtTotal1" class="form-group col-xs-12 col-lg-2">
		                    <input type="text" class="form-control text-right" name="txtTotal" id="IdtxtTotal" value="<?php if(isset($_SESSION["total2Mostrar"]))echo "$ ".$_SESSION["total2Mostrar"];?>" readonly="">
		                </div>
		                
	                </div>
	                <div id="idConfirmacion" title="Aviso" style="display:none">
	                </div>

                </div>
			</div>
			<!-- /.row -->
		</div>
		<!-- /#page-wrapper -->
	</div>
	<!-- /#wrapper -->
	
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

	
</body>
</html>