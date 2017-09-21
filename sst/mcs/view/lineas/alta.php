<?php
    // if(!isset($_SESSION['gxc_usuario']))
    //     header('Location: ../view/index.php');
    //Poner sesiones principales 

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Módulo de Sistemas | Spar México</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>ST</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Spar Todopromo</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
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
              <!-- User image -->
              <li class="user-header">
                <img src="/mdr/dist/img/foto-160x160.jpg" class="img-circle" alt="Foto de Usuario">
                <p>
                  Nombre completo
                  <small>No. Empleado | Puesto que desempeña</small>
                </p>
              </li>
              <!-- Cuerpo del Menú superior derecho -->
              <li class="user-body">
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
                </div>
                <!-- Fin del cuerpo del Menú superior derecho -->
              </li>
              <!-- Menú en pie de página menú superior derecho-->
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
<!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
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
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!-- <li class="header">Solicitudes</li> -->
            <li>
              <a href="/mcs/view/index.php">
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
<!-- Comienza captura de pantalla -->
<div class="row">
<!-- Columna Iquierda -->
<div class="col-md-12">
<!-- Forma de elementos generales -->
  <div class="box box-primary">
      <div class="box-header with-border">
          <h3 class="box-title">Captura de Celulares</h3>
      </div>
                        <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">IMEI</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Número IMEI del celular">
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputPassword1">Nombre</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Nombre completo">
                </div>
                


        </section>
            <!-- Termina captura de pantalla -->

                <!-- /.box-header -->

                <!-- form start -->

                        </div>
                      </div>
                      <!-- /.tab-content -->
                    </div>
                    <!-- /.col-md-12 -->
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
        </div>
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
    <!-- Validaciones -->
    <script src="../../assets/js/validacion/validacion.js"></script>
    <!-- AdminLTE App -->
    <script src="../../assets/js/app.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../../assets/js/funciones.js"></script>
    <!-- Alta Lineas -->
    <script src="../js/V1/bancos/alta.js"></script>
  </body>
</html>
