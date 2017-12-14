<?php
// if(!isset($_SESSION['spar_usuario']))
//   header('Location: ../../index.html');
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
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <!-- Fuentes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Estilo del tema -->
  <link rel="stylesheet" href="../assets/css/AdminLTE.min.css">
  <!-- Poner la carpeta de estilo CSS a utilizar-->
  <link rel="stylesheet" href="../assets/css/_all-skins.min.css">
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
        <a href="../index.php" class="logo">
          <!-- El mini logo es para la barra lateral y está como mini 50x50 pixels -->
          <span class="logo-mini"><b>ST</b></span>
          <!-- logotipo para el estado normal y dispositivos móviles  -->
          <span class="logo-lg">Spar Todopromo</span>
        </a>
        <!-- La cabecera Navbar: Este estilo se puede encontrar en header.less -->
        <?php 
          include_once("../view/includes/datosUsuario.php");
        ?>
      </header>
  <!-- Columna del lado izquierdo. Contiene el logotipo y la barra lateral -->
  <aside class="main-sidebar">
    <!-- Barra lateral: Este estilo se puede encontrar en sidebar.less -->
    <section class="sidebar">
      <!-- Panel de usuario de la barra lateral -->
      <?php 
        include_once("../view/includes/menuIzquierdo.php");
      ?>

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
      <ul class="sidebar-menu">
        <li class="treeview">
              <a href="../controller/crudIndex.php?urlValue=login">
                <i class="fa fa-cog"></i> <span>Parámetros Generales</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="view/salarios/index.php?accion=index"><i class="fa  fa-money"></i> Salarios</a></li>
                <!-- 
                <li><a href="view/categorias/index.php?accion=index"><i class="fa fa-tags"></i> Categorias</a></li>
                <li><a href="view/clientes/index.php?accion=index"><i class="fa fa-users"></i> Clientes</a></li>
                <li><a href="view/proveedores/index.php?accion=index"><i class="fa fa-cubes"></i> Proveedores</a></li>
                <li><a href="view/representantes/index.php?accion=index"><i class="fa fa-male"></i> Representantes</a></li>
                <li><a href="view/mensajerias/index.php?accion=index"><i class="fa fa-truck"></i> Mensajerías</a></li>
                <li><a href="view/usuarios/index.php?accion=index"><i class="fa fa-user"></i> Usuarios</a></li>
                <li><a href="view/regiones/index.php?accion=index"><i class="fa fa-tree"></i> Regiones</a></li>-->
              </ul>
        </li>
        <li class="header">Contratacion</li>
            <!-- Find e la barra de separación entre menus -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Módulo de Contratación</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="view/perfiles/index.php?accion=index"><i class="fa fa-user-plus"></i> Perfiles</a></li>
                <li><a href="view/requisicion/index.php?accion=index"><i class="fa fa-user-plus"></i> Requisición</a></li>            
                <li><a href="view/vacantes/index.php?accion=index"><i class="fa fa-user-plus"></i> Vacantes</a></li>
                <li><a href="view/reclutamientos/index.php?accion=index"><i class="fa fa-users"></i> Reclutamiento</a></li>
                <li><a href="#"><i class="fa fa fa-cogs"></i> Entrevistas</a></li>
                <li><a href="#"><i class="fa fa fa-cogs"></i> Contratación</a></li>
                <li><a href="#"><i class="fa fa fa-cogs"></i> Orgranigrama</a></li>
              </ul>
        </li>
        <li class="treeview">
          <a href="../controller/crudIndex.php?urlValue=login">
            <i class="fa fa-cog"></i> <span>Empleados</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="view/prospectos/index.php?accion=alta"><i class="fa fa-user"></i>Alta-Empleado</a></li>
            <li><a href="../controller/crudProspecto.php?accion=modificar"><i class="fa  fa-edit"></i>Editar-Empleado</a></li>
          </ul>          
        </li>
        <li class="treeview">
          <a href="../controller/crudIndex.php?urlValue=login">
            <i class="fa fa-cog"></i> <span>Vacantes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../controller/crudVacantes.php?accion=index"><i class="fa fa-user"></i>Solicitud-Vacantes</a></li>
            </ul>          
        </li>
        <li class="treeview">
          <li><a href="../view/representantes/index.php?accion=index"><i class="fa fa-user"></i>Representante</a></li>
        </li>

        <!-- Barra de separación entre menus -->
        <li class="header"></li>
        <!-- Find e la barra de separación entre menus -->
        
        <li>
          <a href="../index.php">
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
          Módulo Recursos Humanos
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
        Todos los derechos reservados 2017 - <strong>Módulo Administrativo</strong> | Spar Todopromo, SAPI de C.V.
      </footer>
    <!-- Fin del pie de página -->
    <!-- ./wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../assets/js/jquery/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/js/app.min.js"></script>
    <!-- Index Módulo Administrativo -->
    <script src="js/V1/index.js"></script>
  </body>
</html>