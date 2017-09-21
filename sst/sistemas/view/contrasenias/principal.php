<?php
    if(!isset($_SESSION['spar_usuario']))
       header('Location: ../index.php');
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
  <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
  <!-- Fuentes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
    <link rel="stylesheet" href="../../../assets/css/datatables/dataTables.bootstrap.css">
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
              <span class="hidden-xs"><?php echo $datosUsuario["nombre"];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- Foto del usuario -->
              <li class="user-header">
                <img src="/mdr/dist/img/foto-160x160.jpg" class="img-circle" alt="Foto de Usuario">
                <p>
                  <?php echo $datosUsuario["nombre"];?>
                  <small>No. Empleado: <?php echo $datosUsuario["empleados_numero_empleado"];?> | Puesto que desempeña</small>
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
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-unlock"></i></a>
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
        
          <li>
          <a href="..">
            <i class="fa fa-arrow-circle-left"></i> <span>Regresar</span>
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
          Consulta de Contraseñas
            <small>Módulo de Sistemas</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Inicio > Consultas > Contraseñas</a></li>
          </ol>
        </section>
        <!-- ./col -->
        <section>
        <section class="content">
          <div class="row">
            <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Empleados</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                  <table id="tblContrasenias" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Correo Agencia</th>
                      <th>Contraseña computadora</th>
                      <th>Contraseña correo</th>
                      <th>Expira</th>
                      <th>Editar</th>    
                      <th>Eliminar</th>                
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($empleados as $empleado){
                    ?>
                    <tr>
                      <td><?php echo $empleado['nombre']; ?></td>
                      <td><?php echo $empleado['correoagencia']; ?></td>
                      <td><?php echo $empleado['contraseniacomp']; ?></td>
                      <td><?php echo $empleado['contraseniacorreo']; ?></td>
                      <td><?php if($empleado['expira']<1) echo "Expirado"; else echo $empleado['expira'] . " días"; ?></td>
                      <td class = "text-center">
                        <a >
                          <i class="fa fa-edit" onclick="editar('<?php echo $empleado['nombre']; ?>','<?php echo $empleado['correoagencia']; ?>','<?php echo $empleado['contraseniacomp']; ?>','<?php echo $empleado['contraseniacorreo']; ?>','<?php echo $empleado['expiracion']; ?>');"></i>
                        </a>
                      </td>
                      <td class = "text-center">
                        <a>
                          <i class="fa fa-trash text-red" onclick="tmp();"></i>
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
          </section>
      </div>
      <!-- Termina el contenido general de la página -->
  
      <!-- ************** Modal Editar ************* -->
      <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        
      </div>    

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
    <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../../assets/js/jquery/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- DataTables -->
    <script src="../../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
           
    <!-- Index Módulo Administrativo -->
    <script src="../../js/V1/index.js"></script>
    <script src="../../js/V1/contrasenias/index.js"></script>
    <!-- index Contrasenias -->
    
  </body>
</html>