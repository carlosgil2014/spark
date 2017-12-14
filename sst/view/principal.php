<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="Carlos Enrique Gil, Gerardo Medina, Salvador Luna y Victor Nava">
  <title>Sistema Spar Todopromo | Spar México</title>
  <!-- Indicadores para respuestas de la plantilla -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
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
    <?php 
      include_once("includes/modalExpiracion.php");
    ?>
    <div class="loader">
    </div>
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="../view/" class="logo">
          <!-- El mini logo es para la barra lateral y está como mini 50x50 pixels -->
          <span class="logo-mini"><b>ST</b></span>
          <!-- logotipo para el estado normal y dispositivos móviles  -->
          <span class="logo-lg">Spar Todopromo</span>
        </a>
        <?php
          include_once("includes/datosUsuario.php");
        ?>
      </header>
      <!-- Columna del lado izquierdo. Contiene el logotipo y la barra lateral -->
      <aside class="main-sidebar">
      <!-- Barra lateral: Este estilo se puede encontrar en sidebar.less -->
      <section class="sidebar">
        <?php 
        include_once("includes/menuIzquierdo.php");
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
      <!-- Barra de separación entre menus -->
        <li class="header"></li>
      <!-- Find e la barra de separación entre menus -->

      <ul class="sidebar-menu">

        <li><a href="directorio/index.php?accion=index"><i class="fa fa-phone"></i> Directorio SPAR</a></li>
        <li><a href="#"><i class="fa fa-support"></i> Solicitud de Soporte</a></li>
        <li><a href="../mensajeria/index.php?accion=index"><i class="fa  fa-truck"></i> Mensajería</a></li>
        <?php
        if($datosUsuario["mrs"] == 1){
        ?>
        <li class="treeview">
          <a href="../srs/index.php?accion=index">
            <i class="fa fa-users"></i> <span> Módulo Operativo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right"></i>
            </span>
          </a>
        </li>
        <?php 
        }
        if($datosUsuario["mcg"] == 1){
        ?>
        <li class="treeview">
          <a href="http://www.scg.spar-todopromo.mx">
            <i class="fa fa-usd"></i> <span> Módulo de Gastos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right"></i>
            </span>
          </a>
        </li>
        <?php 
        }
        if($datosUsuario["mcc"] == 1){
        ?>
        <li class="treeview">
          <a href="../compras/index.php?accion=index">
            <i class="fa fa-shopping-cart"></i> <span> Módulo de Compras</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right"></i>
            </span>
          </a>
        </li>
        <?php 
        }
        if($datosUsuario["ms"] == 1){
        ?>
        <li class="treeview">
          <a href="../sistemas/index.php?accion=index">
            <i class="fa fa-desktop"></i> <span> Módulo de Sistemas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right"></i>
            </span>
          </a>
        </li>
        <?php 
        }
        if($datosUsuario["ma"] == 1){
        ?>
        <li class="treeview">
          <a href="../administrativo/index.php?accion=index">
            <i class="fa fa-sitemap"></i> <span> Módulo Administrativo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right"></i>
            </span>
          </a>
        </li>
        <?php 
        }
        if($datosUsuario["mrh"] == 1){
        ?>
        <li class="treeview">
          <a href="../rh/index.php?accion=index">
            <i class="fa fa-male"></i> <span> Módulo Recursos Humanos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right"></i>
            </span>
          </a>
        </li>
        <?php 
        }
        ?>
        </li>
        <!-- Barra de separación entre menus -->
        <li class="header"></li>
        <!-- Find e la barra de separación entre menus -->
        

        <li>
          <a href="index.php?accion=logout">
            <i class="fa fa-power-off"></i> <span> Salir</span>
            
          </a>
        </li>
    </section>
    <!-- Termina barra de menus -->
  </aside>

      <!-- Contenido general de la página -->
      <div class="content-wrapper">

        <!-- Titulo para encabezado de la pantalla central -->
        <section class="content-header">
          <h1>
          Sistema Spar Todopromo
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i></a></li>
          </ol>
          <section>

          </section>
        <!-- ./col -->

      </div>
      <!-- Termina el contenido general de la página -->
      <?php 
        include_once("includes/footer.php");
      ?>
      <!-- Inicio del pie de página -->
      
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
    <script src="../js/V1/index.js"></script>
  </body>
</html>