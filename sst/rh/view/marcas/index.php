<?php
// if(!isset($_SESSION['kiosco_usu']))
//     header('Location: ../index.html');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
    <meta name="author" content="Maria de los Angeles Malagon, Salvador Luna, Victor Nava y Gerardo Medina">
    <title>Módulo de Control de Recursos | Spar México</title>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../assets/css/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../assets/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../assets/css/_all-skins.min.css">

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
        <a href="../index.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>ST</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Spar TodoPromo</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             <!-- Detalle de usuario de la parte superior derecha -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/mdr/dist/img/foto-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Quien inició sesión</span>
            </a>
            <ul class="dropdown-menu">
              <!-- Foto del usuario -->
              <li class="user-header">
                <img src="/mdr/dist/img/foto-160x160.jpg" class="img-circle" alt="Foto de Usuario">
                <p>
                  Nombre completo
                  <small>No. Empleado | Puesto que desempeña</small>
                </p>
              </li>
              <!-- Cuerpo del Menú superior derecho -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Menú 1</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Menú 2</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Menú 3</a>
                  </div>
                </div> -->
                <!-- Fin del cuerpo del Menú superior derecho -->
              </li>
              <!-- Menú en pie de página del menú superior derecho-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfíl del Usuario</a>
                </div>
                <div class="pull-right">
                  <a href="<a href="../controller/indexControlador.php?urlValue=logout" class="btn btn-default btn-flat">Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </li>
                            
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- search form -->
          <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Buscar...">
                  <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form> -->
           <!-- Panel de usuario de la barra lateral -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/mdr/dist/img/foto-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Usuario Activo</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
        </div>
      </div>
       <!-- Barra de separación entre menus -->
        <li class="header">Opciones</li>
      <!-- Fin de la barra de separación entre menus -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!-- <li class="header">Solicitudes</li> -->
            <li>
              <a href="../controller/crudMarcas.php?accion=alta"> 
                <i class="fa fa-plus"></i> <span>Agregar</span>
              </a>
            </li>
            <li>
              <a href="../">
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
                  <h3 class="box-title">Marcas/Principal</h3>

                </div>

                <!-- /.box-header -->
                <div class="box-body table-responsive">
                  <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                  <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                    <div class="col-md-4 col-md-offset-4">
                      <div class="alert alert-success" >
                        <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                        <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                      </div>
                    </div>
                  </div>
                  <table id="tblMarcas" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Marca</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($marcas as $Marca){
                    ?>
                    <tr>
                      <td><?php echo $Marca["marca"]?></td>
                      <td class = "text-center">
                        <a href="crudMarcas.php?accion=modificar&idMarca=<?php echo $Marca['idmarca'];?>">
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
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <!-- <b>Version</b> 2.3.8 -->
        <!-- Inicio del pie de página -->
        <b>Versión</b> 1.0.0
        </div>
        Todos los derechos reservados 2017 - <strong>Modulo de Control de Recursos</strong> | Spar Todopromo, SAPI de C.V.
        <strong><!-- © 2017 Recibos de Nómina | Spar Todopromo, SAPI de CV --></strong>
      </footer>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <script src="../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Validaciones -->
    <script src="../../assets/js/validacion/validacion.js"></script>
    <!-- AdminLTE App -->
    <script src="../../assets/js/app.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../../assets/js/funciones.js"></script>
    <!-- Index Bancos -->
    <script src="../js/V1/marcas/index.js"></script>
  </body>
</html>
