<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: ../index.php');
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
    <div class="loader">
    </div>
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../index.php?accion=index" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>S | T</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Compras | Spar</span>
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
          <ul class="sidebar-menu">
            <!-- <li class="header">Solicitudes</li> -->
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
                  <h3 class="box-title">Parámetros del Módulo</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                  <div class="row">
                    <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                    <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                      <div class="col-md-4 col-md-offset-4">
                        <div class="alert alert-<?php if(isset($_GET["clase"])){echo $_GET["clase"];}?>" >
                          <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                          <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#divProductos" data-toggle="tab" aria-expanded="true">Productos</a></li>
                      <li class=""><a href="#divServicios" data-toggle="tab" aria-expanded="false">Servicios</a></li>
                      <li class=""><a href="#divUnidades" data-toggle="tab" aria-expanded="false">Unidades</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="divProductos">
                        <div class="page-header">
                          <button type="button" onclick="agregarProducto();" class="btn btn-success btn-flat btn-sm">Agregar</button>
                        </div>
                        <table id="tblProductos" class="table table-bordered table-striped small">
                          <thead>
                          <tr>
                            <th>Nombre</th>
                            <th></th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php 
                          foreach($productos as $producto){
                          ?>
                          <tr>
                            <td><?php echo $producto["nombre"];?></td>  
                            <td class = "text-center">
                              <a style="cursor: pointer;" onclick="modificarProducto('<?php echo $producto["idProducto"];?>');">
                                <i class="fa fa-search"></i>
                              </a>
                            </td>
                          </tr>
                          <?php
                          }
                          ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="divServicios">
                        <div class="page-header">
                          <button type="button" onclick="agregarServicio();" class="btn btn-success btn-flat btn-sm">Agregar</button>
                        </div>
                        <table id="tblServicios" class="table table-bordered table-striped small">
                          <thead>
                          <tr>
                            <th>Nombre</th>
                            <th></th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php 
                          foreach($servicios as $servicio){
                          ?>
                          <tr>
                            <td><?php echo $servicio["nombre"];?></td>  
                            <td class = "text-center">
                              <a style="cursor: pointer;" onclick="modificarServicio('<?php echo $servicio["idServicio"];?>');">
                                <i class="fa fa-search"></i>
                              </a>
                            </td>
                          </tr>
                          <?php
                          }
                          ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="divUnidades">
                        <div class="page-header">
                          <button type="button" onclick="agregarUnidad();" class="btn btn-success btn-flat btn-sm">Agregar</button>
                        </div>
                        <table id="tblUnidades" class="table table-bordered table-striped small">
                          <thead>
                          <tr>
                            <th>Nombre</th>
                            <th></th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php 
                          foreach($unidades as $unidad){
                          ?>
                          <tr>
                            <td><?php echo $unidad["nombre"];?></td>  
                            <td class = "text-center">
                              <a style="cursor: pointer;" onclick="modificarUnidad('<?php echo $unidad["idUnidad"];?>');">
                                <i class="fa fa-search"></i>
                              </a>
                            </td>
                          </tr>
                          <?php
                          }
                          ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
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
      <div class="modal fade" id="modalParametros" role="dialog">              
      </div>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
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
    <!-- Bootstrap select js -->
    <script src="../../../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../../../assets/js/funciones.js"></script>
    <!-- Index Proveedores -->
    <script src="../../js/V1/parametros/index.js"></script>
  </body>
</html>
