 <?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: ../../../idex.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
    <title>Módulo de Control de Recursos | Spar México</title>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../assets/css/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../assets/css/AdminLTE.min.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap/bootstrap-select.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../../assets/css/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <?php 
      include_once("../../../view/includes/modalExpiracion.php");
    ?>
    <div class="loader">
    </div>
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../../index.php?accion=index" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A | S</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Administrativo | Spar</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <?php 
          include_once("../../../view/includes/datosUsuario.php");
        ?>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <?php 
            include_once("../../../view/includes/menuIzquierdo.php");
          ?>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!-- <li class="header">Solicitudes</li> -->
            <li>
              <a style="cursor: pointer;" onclick="agregar();"> 
                <i class="fa fa-plus"></i> <span>Agregar</span>
              </a>
            </li>
            <li>
              <a href="../../index.php?accion=index">
                <i class="fa fa-arrow-left"></i> <span>Regresar</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- right column -->
            <div class="col-md-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Cotizaciones/Nueva</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form name="cotizaciones" method="post" action="index.php?accion=agregarCotizacion">
                    <div class="row">
  	                  <div class="form-group col-lg-6" >
  	                    <label>Cliente</label>
  	                    <select class="form-control input-sm datosText" name="cmbClientes" id="IdcmbClientes" data-container="body" data-live-search="true" onchange="cargarConceptos();" required>
  	                      <option data-hidden="true" selected value="">Seleccione Cliente</option>
  	                      <?php 
  	                        foreach ($datosClientes as $cliente) {
  	                        ?>
  	                        <option value="<?php echo $cliente['nombreComercial']."#".$cliente['idclientes']; ?>" <?php if(isset($_SESSION["idCliente"]) && $_SESSION["idCliente"] == $cliente["idclientes"]) echo "selected"; ?>><?php echo $cliente["nombreComercial"]." - ".$cliente["razonSocial"];?></option>
  	                        <?php 
  	                        }
  	                      ?> 
  	                    </select>
  	                  </div>
  	                  <div class="form-group col-lg-3" >
  	                    <label>De</label>
  	                    <input  type="date" class="form-control input-sm text-center datosText" name="fInicial" id="fechaIn" value="<?php if(isset($_SESSION["fechaInicial"])){echo $_SESSION["fechaInicial"];}else{ echo date("Y-m-d");}?>" required>
  	                  </div>
  	                  <div class="form-group col-lg-3" >
  	                    <label>Hasta</label>
  	                    <input type="date" class="form-control input-sm text-center datosText" name="fFinal" id="fechaFin" value="<?php if(isset($_SESSION["fechaFinal"]))echo$_SESSION["fechaFinal"];else echo date("Y-m-d");?>" required>
  	                  </div>
                    </div>
                    <div class="row">
  	                  <div class="form-group col-lg-6" >
  	                    <label>Servicio</label>
  	                    <input  type="text" class="form-control input-sm datosText" name="txtServicio" id="IdtxtServicio" value="<?php if(isset($_SESSION["servicio"])) echo$_SESSION["servicio"];?>" required>
  	                  </div>
  	                  <div class="form-group col-lg-3" >
  	                    <label>Tipo de Plan</label>
  	                    <select tabindex="5" class="form-control input-sm selectpicker datosText" data-style="btn-info btn-flat btn-sm" name="cmbTipoPlan" id="IdcmbTipoPlan" required >
                        	<option disabled selected data-hidden="true" value="">Seleccione</option>
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
  	                  <div class="form-group col-lg-3" >
  	                    <label>Tipo de Servicio</label>
    	                    <select tabindex="6" class="form-control selectpicker datosText" data-style="btn-info btn-flat btn-sm" name="cmbTipoServicio" id="IdcmbTipoServicio" onchange="cargarConceptos();" required>
                    			 <option selected data-hidden="true" value="">Seleccione</option>
            							<?php 
            							$i=0;
            							foreach ($arrayTipoServicio as $tipoServicio) 
            							{
            							?>
            							 <option <?php if(isset($_SESSION["tipoServicio"]) && $_SESSION["tipoServicio"] == $tipoServicio) echo "selected"?>><?php echo $tipoServicio;?></option>
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
                        <input tabindex="7" type="number" min="1" class="form-control text-right input-sm" name="txtCantidad" id="IdtxtCantidad" title="Se necesita una cantidad" required>
                      </div>
  						        <div class="form-group col-xs-6 col-lg-3" >
                        <label >Concepto</label>                         
                        <select tabindex="8" class="form-control selectpicker" data-live-search="true" name="cmbTipoConcepto" data-style="btn-info btn-flat btn-sm" id="IdcmbTipoConcepto" required>
                        	<option data-hidden="true" selected value="">Seleccione Concepto</option>
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
                          <span class='input-group-addon'>$</span><input tabindex="9" type="number" class="form-control text-right input-sm" name="txtPUnitario" id="IdtxtPUnitario" value="" step="0.01" min="0.01"  title="Se necesita un precio unitario" required>
                        </div>
                      </div>
                      <div class="form-group col-xs-6 col-lg-2" >
                        <label>Comisión</label>
                        <div class="input-group">
                          <input tabindex="10" type="number" class="form-control text-right input-sm" name="txtComisionAgencia" id="IdtxtComisionAgencia" step="0.01" min="0.00"><span class='input-group-addon'>%</span>
                        </div>
                      </div>
                      <div class="form-group col-xs-6 col-lg-2" >
                        <label>Subtotal</label>
                        <div class="input-group">
                          <span class='input-group-addon'>$</span><input type="text" class="form-control text-right input-sm" name="txtSubtotal" id="IdtxtSubTotal1" readonly>
                        </div>
                        
                      </div>
                      <div class="form-group col-xs-6 col-lg-1">
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <button type="submit" class="btn btn-flat btn-primary btn-sm">Agregar</button>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-5 descripcionConcepto hidden">
                        <label name="lblDescripcionConcepto" id="IdlblDescripcionConcepto">Descripción del concepto</label>
                        <input type="text" class="form-control input-sm" name="txtDescripcionConcepto" id="IdtxtDescripcionConcepto" />
                      </div>
                    </div>
                  </form>
                  <div id="IdtxtCotizacion" name="txtCotizacion" class="table-responsive container-fluid row">
                    <!--Carga los datos de una cotizacion agregada-->
                    <table class="table table-bordered table-condensed small ">
                    <?php 
                    if (isset($_SESSION['contador']) and $_SESSION['contador']>0) {
                      if (isset($_SESSION['contador']) and $_SESSION['contador']!=""){
                    ?>
                      <tr class="text-center bg-primary">
                        <td>Cantidad</td>
                        <td>Concepto</td>
                        <td>Precio Unitario</td>
                        <td>Total</td>
                        <td>Comisión</td>
                        <td>Subtotal</td>
                      </tr> 
                    <?php
                        for($i=1;$i<=$_SESSION['contador'];$i++) {
                     ?>
                      <!-- <tr class="text-center">
                        <td>Tipo de Plan</td>
                        <td colspan="2"><?php echo $_SESSION['cmbTipoPlan'][$i];?></td>
                        <td>Tipo de Servicio</td>
                        <td colspan="2"><?php echo $_SESSION['cmbTipoServicio'][$i];?></td>
                      </tr> -->
                     
                      <tr class="text-center">
                          <td><?php echo $_SESSION['txtCantidad'][$i];?></td>
                          <td><?php echo $_SESSION['cmbTipoConcepto'][$i];?></td>
                          <td>$ <?php echo $_SESSION['txtPUnitarioMostrar'][$i];?></td>
                          <td>$ <?php echo number_format(($_SESSION["precioTotal"][$i]),2);?></td>
                          <td>
                            <a  class='tool' data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='<?php echo $_SESSION['txtComisionAgenciaM'][$i];?> %'>$ 
                            <?php 
                            if ($_SESSION['txtComisionAgencia'][$i]>"0" || $_SESSION['txtComisionAgencia'][$i]=="0") {
                              echo number_format($_SESSION['txtComisionAgencia'][$i],2);
                            }
                            else
                              echo "0.00";?> 
                          </a>
                          </td>
                          <td>$ <?php echo $_SESSION['subTotalMostrar'][$i];?></td>
                      </tr> 
                    <?php
                          if(!empty($_SESSION['txtDescripcionConcepto'][$i])){
                    ?>  
                      <tr>
                        <td></td>
                        <td colspan="6"><?php echo $_SESSION['txtDescripcionConcepto'][$i];?></td>
                      </tr>
                    <?php
                          }
                        } 
                      }
                    ?>
                    <?php 
                    }
                    ?>
                      <tr>
                        <td colspan="4" rowspan="2" class="active" style="vertical-align:bottom;">
                          <label>Importe con letra y número </label>
                        </td>
                        <td  class="text-center">Subtotal </td>
                        <td class="active text-center">
                          <?php if(isset($_SESSION["subTotal2Mostrar"]))echo "$ ".$_SESSION["subTotal2Mostrar"];?>
                        </td>
                      </tr>
                      <tr class="text-center">
                        <td>IVA 16% </td>
                        <td class="active text-center"><?php if(isset($_SESSION["ivaMostrar"]))echo "$ ".$_SESSION["ivaMostrar"];?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4" class="active" id="IdtxtCantidadLetra"></td>
                        <td class="text-center">Total</td>
                        <td id="IdtxtTotal" class="active text-center">
                          <?php if(isset($_SESSION["total2Mostrar"]))echo "$ ".$_SESSION["total2Mostrar"];?>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php
      include_once("../../../view/includes/footer.php");
      ?>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <!-- <div class="control-sidebar-bg"></div> -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Validaciones -->
    <script src="../../../assets/js/validacion/validacion.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- Funciones Generales -->
    <!-- <script src="../../../assets/js/funciones.js"></script> -->
    <!-- Bootstrap select js -->
    <script src="../../../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Index Bancos -->
    <script src="../../js/V1/cotizaciones/index.js"></script>
  </body>
</html>
