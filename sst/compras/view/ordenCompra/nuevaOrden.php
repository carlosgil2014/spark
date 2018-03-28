<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: ../../../view/index.php?accion=login');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../../../img/favicon.ico" type="image/x-icon" />
  <title>Sistema Spar Todopromo | Spar México</title>
  <!-- Indicadores para respuestas de la plantilla -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
  <!-- Fuentes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Estilo del tema -->
  <link rel="stylesheet" href="../../../assets/css/AdminLTE.min.css">
  <!-- Poner la carpeta de estilo CSS a utilizar-->
  <link rel="stylesheet" href="../../../assets/css/_all-skins.min.css">
  <!-- Soporte de elementos HTML5 para Respond.js, IE8 y media queries -->
  <!-- ADVERTENCIA: Respond.js no funcionará si se visualiza con IE 9:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="">
    </div>
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="../../../index.php" class="logo">
          <!-- El mini logo es para la barra lateral y está como mini 50x50 pixels -->
          <span class="logo-mini"><b>ST</b></span>
          <!-- logotipo para el estado normal y dispositivos móviles  -->
          <span class="logo-lg">Spar Todopromo</span>
        </a>
        <!-- La cabecera Navbar: Este estilo se puede encontrar en header.less -->
        <?php 
          include_once("../../../view/includes/datosUsuario.php");
        ?>
      </header>
      <!-- Columna del lado izquierdo. Contiene el logotipo y la barra lateral -->
      <aside class="main-sidebar">
        <!-- Barra lateral: Este estilo se puede encontrar en sidebar.less -->
        <section class="sidebar">
          <!-- Panel de usuario de la barra lateral -->
          <?php 
            include_once("../../../view/includes/menuIzquierdo.php");
          ?>
          <!-- Comienza barra de menus: : Estilos encontrados en Less -->
          <ul class="sidebar-menu">
                            
        	<li>
              <a href="index.php?accion=index">
                <i class="fa fa-hand-o-left"></i> <span>Regresar</span> 
              </a>
            </li>
          </ul>
        </section>
        <!-- Termina barra de menus -->
      </aside>
      <!-- Contenido de la página -->
      <div class="content-wrapper">
        <section class="content-header">
          <h4>
            Nueva orden de compra
          </h4>
          <ol class="breadcrumb">
            <li><a href="index.php?accion=index"><i class="fa fa-plus-square"></i>Regresar</a></li>
          </ol>
        </section>
    	
        <!-- Main content -->
        <section class="content">
          <div class="row">
          	<div class="col-xs-12">
          		<div class="box box-info">
                <div class="box-body">
                  <div class="row">
                    <div class="col-xs-offset-9 form-group">
                      <label class="label-control">N°Orden</label>
                      <input type="text" disabled>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-4 form-group">
                      <label class="label-control" >Centro de costos</label>
                      <select class="form-control input-sm" name="" id="" required="">
                        <option hidden="" selected="">Seleccione Cliente</option>
                        <option value="1">LEVIS</option>
                        <option value="50">MALTA</option>
                      </select>
                    </div>
                    <div class="col-xs-4 form-group">
                      <label class="label-control">Proveedor</label>
                      <select class="form-control input-sm" name="" id="" required="">
                        <option hidden="" selected="">Seleccione Cliente</option>
                        <option value="1">LEVIS</option>
                        <option value="50">MALTA</option>
                      </select>  
                    </div>
                    <div class="col-xs-4 form-group">
                      <label class="label-control">Tipo de proveedor</label>
                      <input type="text" class="form-control input-sm">
                    </div>  
                  </div>

                  <div class="row">
                    
                    <div class="col-xs-4">
                      <label class="label-control">Cargo a cliente</label>
                      <div>
                        <label class="radio-inline"><input type="radio" name="cargoCliente">Si</label>
                        <label class="radio-inline"><input type="radio" name="cargoCliente">No</label>
                      </div>
                    </div>

                    <div class="col-xs-4 form-group">
                      <label class="label-control">Orden de servicio</label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-xs-4 form-group">
                      <label class="label-control">Transferencia</label>
                      <div>
                        <label class="radio-inline"><input type="radio" name="transferencia">Si</label>
                        <label class="radio-inline"><input type="radio" name="transferencia">No</label>
                      </div>
                    </div>  
                  </div>

                  <div class="row">
                    
                    <div class="col-xs-4 form-group">
                      <label class="label-control">Banco</label>
                      <input class="form-control" type="text">                    
                    </div>

                    <div class="col-xs-4 form-group">
                      <label class="label-control">Cuenta/Clabe</label>
                      <input class="form-control" type="text">                    
                    </div>

                    <div class="col-xs-4 form-group">
                      <label for="" class="label-control">Anticipo</label>
                      <div>
                        <label class="radio-inline"><input type="radio" name="anticipo">Si</label>
                        <label class="radio-inline"><input type="radio" name="anticipo">No</label>
                      </div>
                      
                    </div>
                  </div>

                  <div class="row">&nbsp</div> 

                  <div class="row">
                    <div class="col-lg-12 col-xs-12 table-responsive">
                      <table class="table table-hover table-bordered table-condensed text-center">
                        <tbody>
                          <tr>
                            <th>Cantidad</th>
                            <th>Precio Unit</th>
                            <th>Precio Total</th>
                            <th>Subtotal</th>
                            <th>IVA</th>
                            <th>TOTAL</th>
                          </tr>
                        </tbody>
                        <tbody id="filas">
                            <tr class="filasR">
                              <td><input class="form-control input-sm text-center" name="Datos[fechas][]" type="text" required=""></td>
                              
                              <td><input class="form-control input-sm text-center" name="Datos[factura][]" type="text"></td>
                              <td><input class="subtotal form-control input-sm text-center" name="Datos[subtotal][]" type="number" step="0.01" required=""></td>
                              <td><input class="impuestos form-control input-sm text-center" name="Datos[impuesto][]" type="number" step="0.01"></td>
                              <td><input class="iva form-control input-sm text-center" name="Datos[iva][]" type="number" step="0.01"></td>
                              <td><input class="total form-control input-sm text-center" type="number" step="0.01" readonly="" required=""></td>
                            </tr> 
                        </tbody>
                        <tbody>
                          <tr>
                            <td><a id="agregarFila" style="cursor:pointer;" data-toggle="tooltip" title="Agregar nueva fila"><i class="fa fa-plus"></i></a></td>
                            <td><input class="form-control input-sm text-center" id="iva" readonly="" value=""></td>
                            <td><input class="form-control input-sm text-center" id="iva" readonly="" value=""></td>
                            <td><input class="form-control input-sm text-center" id="subtotal" readonly="" value=""></td>
                            <td><input class="form-control input-sm text-center" id="impuestos" readonly="" value=""></td>
                            <td><input class="form-control input-sm text-center" id="iva" readonly="" value=""></td>
                            
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-4">
                      <input type="submit" class="btn btn-success" value="Guardar">
                    </div>
                  </div> 

                </div>
          	</div>
          </div><!-- ./row -->
        </section>

      </div><!-- /.content-wrapper -->
      

      <!-- Termina el contenido general de la página -->
      
      <!-- Inicio del pie de página -->
      <?php
        include_once("../../../view/includes/footer.php");
      ?>
      <!-- Fin del pie de página -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../../assets/js/jquery/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- Index Módulo Administrativo -->
    <script src="js/V1/index.js"></script>
  </body>
</html>