<?php
    // if(!isset($_SESSION['spar_usuario']))
    //     header('Location: ../view/index.php');
    //Poner sesiones principales 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="Carlos Enrique Gil, Gerardo Medina, Salvador Luna y Victor Nava">
  <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
  <title>Sistema Spar Todopromo | Spar México</title>
  <!-- Indicadores para respuestas de la plantilla -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <!-- Fuentes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Estilo del tema -->
  <link rel="stylesheet" href="../../assets/css/AdminLTE.min.css">
  <!-- Poner la carpeta de estilo CSS a utilizar-->
  <link rel="stylesheet" href="../../assets/css/_all-skins.min.css">
  <!-- Soporte de elementos HTML5 para Respond.js, IE8 y media queries -->
  <!-- ADVERTENCIA: Respond.js no funcionará si se visualiza con IE 9:// -->
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
        <a href="../../view/index.php" class="logo">
          <!-- El mini logo es para la barra lateral y está como mini 50x50 pixels -->
          <span class="logo-mini"><b>ST</b></span>
          <!-- logotipo para el estado normal y dispositivos móviles  -->
          <span class="logo-lg">Spar Todopromo</span>
        </a>
        <!-- La cabecera Navbar: Este estilo se puede encontrar en header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Botón de desplazamiento de la barra lateral-->
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
                  <a href="../controller/crudIndex.php?urlValue=logout" class="btn btn-default btn-flat">Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </li>

        <!-- Botón superior derecho asignado para bloquear la sesión -->
            <li>
                <a href="../controller/crudBloquear.php?urlValue=logout" data-toggle="control-sidebar"><i class="fa fa-unlock"></i></a>
            </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Columna del lado izquierdo. Contiene el logotipo y la barra lateral -->
  <aside class="main-sidebar">
    <!-- Barra lateral: Este estilo se puede encontrar en sidebar.less -->
    <section class="sidebar">
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

      <!-- Buscador -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Buscar...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- Fin de Buscador -->

      <!-- Comienza barra de menus: : Estilos encontrados en Less -->

      

        <!-- Barra de separación entre menus -->
      <li class="header"></li>
        <!-- Find e la barra de separación entre menus -->

      <ul class="sidebar-menu">
      <li class="treeview">
          <a href="#">
            <i class="fa fa-mobile-phone"></i> <span>Celulares</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li>
              <a href="#"><i class="fa fa-plus"></i> Asignaciones
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-user"></i> Por Usuario</a></li>
                <li>
                  <a href="#"><i class="fa fa-users"></i> Por Cliente
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-suitcase"></i> Bic</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Concha y Toro</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Digrans</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> eCommerce</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Gridimex</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Herdez</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Malta Cleyton</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Rekitt Benckiser</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Sanfer</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Sony</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> VCT Asesores</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Walmart</a></li>
                  </ul>
                </li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-star-o"></i> Renovaciones
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-user"></i> Administrativas</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Bic</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Concha y Toro</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Digrans</a></li>
                <li><a href="#"><i class="fa fa-user"></i> Directiva I</a></li>
                <li><a href="#"><i class="fa fa-user"></i> Directiva II</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> eCommerce</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Gridimex</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Herdez</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Malta Cleyton</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Rekitt Benckiser</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Sanfer</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Sony</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> VCT Asesores</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Walmart</a></li>
                <li>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-suitcase"></i> Bic</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Concha y Toro</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Digrans</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> eCommerce</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Gridimex</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Herdez</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Malta Cleyton</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Rekitt Benckiser</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Sanfer</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Sony</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> VCT Asesores</a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> Walmart</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-cube"></i> Stock</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="../controller/crudIndex.php?urlValue=login">
            <i class="fa fa-file-text-o"></i> <span>Consultas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="contrasenias/index.php?accion=index"><i class="fa fa-asterisk"></i> Contraseñas</a></li>
            <li><a href="#"><i class="fa fa-mobile"></i> Celulares</a></li>
            <li><a href="#"><i class="fa fa-desktop"></i> Equipos de cómputo</a></li>

          </ul>
        </li>

       <li class="treeview">
          <a href="../controller/crudIndex.php?urlValue=login">
            <i class="fa fa-plus-square"></i> <span>Asignaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-user"></i> Por cliente</a></li>
            <li><a href="#"><i class="fa fa-user"></i> Por empleado</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="../controller/crudIndex.php?urlValue=login">
            <i class="fa fa-cubes"></i> <span>Inventario</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../view/celulares/index.php?accion=index"><i class="fa fa-mobile"></i> Celulares</a></li>
            <li><a href="#"><i class="fa fa-tablet"></i> Tablets</a></li>
            <li><a href="#"><i class="fa fa-dedent"></i> SIMs</a></li>
            <li><a href="#"><i class="fa fa-tv"></i> Monitores</a></li>
            <li><a href="#"><i class="fa fa-keyboard-o"></i> Teclados</a></li>
            <li><a href="#"><i class="ion-mouse"></i>  Mouses</a></li>
            <li><a href="#"><i class="fa fa-laptop"></i> Laptops</a></li>
            <li><a href="#"><i class="fa fa-desktop"></i> Computadoras</a></li>
            <li><a href="#"><i class="fa fa-print"></i> Impresoras</a></li>
            <li><a href="#"><i class="fa fa-tty"></i> Teléfonos</a></li>
          </ul>
        </li>



        <!-- Barra de separación entre menus -->
<!--         <li class="header"></li> -->
        <!-- Find e la barra de separación entre menus -->

<!--         <li class="treeview">
          <a href="#">
            <i class="fa fa-street-view"></i> <span>Solicitar Vacantes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right"></i>
            </span>
          </a>
        </li>-->

                <!-- Barra de separación entre menus -->
        <li class="header"></li>
        <!-- Find e la barra de separación entre menus -->
-->        

        <li>
          <a href="../../view/index.php">
            <i class="fa fa-hand-o-left"></i> <span>Regresar</span>
            
          </a>
        </li>

    </section>
    <!-- Termina barra de menus -->
  </aside>

      <!-- Contenido de la página -->
      <div class="content-wrapper">

        <!-- Titulo para encabezado de la pantalla central -->
        <section class="content-header">
          <h1>
          Módulo de Sistemas
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-sign-in"></i> Inicio</a></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>1</h3>
                  <p>Operaciones</p>
                </div>
                <div class="icon">
                  <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="#" class="small-box-footer">
                  Entrar <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>2<sup style="font-size: 20px"></sup></h3>
                  <p>Finanzas</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">
                  Entrar <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>3</h3>

                  <p>Administrativo</p>
                </div>
                <div class="icon">
                  <i class="ion ion-calculator"></i>
                </div>
                <a href="#" class="small-box-footer">
                  Entrar <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>4</h3>

                  <p>Mantenimiento</p>
                </div>
                <div class="icon">
                  <i class="ion-ios-paper-outline"></i>
                </div>
                <a href="#" class="small-box-footer">
                  Entrar <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
          </div>

        <!-- ./col -->

      </div>
      <!-- /.content-wrapper -->

      <!-- Termina el contenido general de la página -->
      
      <!-- Inicio del pie de página -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Versión</b> 1.0.0
        </div>
        Todos los derechos reservados 2017 - <strong>Módulo de Sistemas</strong> | Spar Todopromo, SAPI de C.V.
      </footer>
    <!-- Fin del pie de página -->
    <!-- ./wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../assets/js/jquery/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../assets/js/app.min.js"></script>
    <!-- Index Módulo Administrativo -->
    <script src="../js/V1/index.js"></script>
  </body>
</html>