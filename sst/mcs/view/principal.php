<?php
    if(!isset($_SESSION['gxc_usuario']))
        header('Location: ../view/index.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Módulo de Control de Recursos | Spar México</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../css/_all-skins.min.css">
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
          <span class="logo-mini"><b>SCG</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Control de gastos</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span><?php echo $dato["nombre"];?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="../controller/indexControlador.php?urlValue=logout" class="btn btn-default btn-flat">Salir</a>
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
         <!--  <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Buscar Folio...">
                  <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form> -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Solicitudes</li>
            <li>
              <a href="../controller/crudGastos.php?accion=listaGastos&activo=1"> 
                <span>Gastos a comprobar</span>
              </a>
            </li>
            <li> 
                <a href="../controller/crudRcg.php?accion=listaRcg&estado=1">
                    <span>Cuentas de gastos</span>
                </a>
            </li>
            <li>
              <a href="../controller/crudrembolsogastos.php?accion=solicitudRembolso&estado=1">
                <span>Comprobaciones y Reembolsos</span>
              </a>
            </li>
            <!-- <li class="header">Más</li> -->
            <li class="treeview"> 
                <a href="#">
                    <span>Información</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../controller/crudSaldoFolios.php?accion=listaGastos&activo=1">Por folio</a></li>
                    <li><a href="../controller/crudsaldoempleados.php?accion=listarDatosEmpleados">Por empleado</a></li>
                    <li><a href="../controller/crudSaldoSolicitante.php?accion=listarDatosSolicitante">Por solicitante</a></li>
                    <li><a href="../controller/crudSaldoCliente.php?accion=listarDatosClientes">Por cliente</a></li>
                    <li><a href="../controller/crudEmpleadosGastos.php?accion=altaEmpleadoGasto">Alta empleado</a></li>
                    <li><a href="../controller/crudEmpleadosGastos.php?accion=listarEmpleados">Modificar empleado</a></li>
                    <li><a href="../controller/crudCliemp.php?accion=listarEmpleados">Clientes / Empleados</a></li>
                </ul>
            </li>
            <li><a href="../controller/crudSaldoFolios.php?accion=listaGastosDescuentos"><span>Descuentos</span></a></li>
            <li class="treeview"> 
                <a href="#">
                    <span>Reportes</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../controller/crudReportes.php?accion=listaEmpleados&activo=1">Por empleado</a></li>
                    <li>
                      <a href="#">Estado de cuenta 
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="../controller/crudEstado.php?accion=listaEmpleados&activo=1">Folios y Reembolsos</a></li>
                        <li><a href="../controller/crudEstado.php?accion=listaEmpleados&activo=2">Fondos Revolventes</a>
                        </li>
                      </ul>
                    </li>
                </ul>
            </li>
            <li class="header">Pantalla principal</li>
            <li>
              <a href="<?php echo $href;?>"> 
                <span><? echo $principalActivo?></span>
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
            <!-- Small boxes (Stat box) -->
          <div class="row">
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3><?php echo count($foliosAbiertos);?></h3>
                    <p>Folios abiertos</p>
                  </div>
                  <a href="#" class="small-box-footer" onclick='tablaPrincipal(<?php echo json_encode($foliosAbiertos);?>,"fa")'>Ver más <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                  <div class="inner">
                    <h3><?php echo count($foliosPorCerrar);?></h3>
                    <p>Folios por cerrar</p>
                  </div>
                  <a href="#" class="small-box-footer" onclick='tablaPrincipal(<?php echo json_encode($foliosPorCerrar);?>,"fc")'>Ver más <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3><?php echo count($cgRechazadas);?></h3>
                    <p>Cuentas de gastos rechazadas</p>
                  </div>
                  <a href="#" class="small-box-footer" onclick='tablaPrincipal(<?php echo json_encode($cgRechazadas);?>,"cr")'>Ver más <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
             
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3><?php echo count($cgNoUtilizadas);?></h3>

                    <p>Cuentas de gastos no utilizadas</p>
                  </div>
                  <a href="#" class="small-box-footer" onclick='tablaPrincipal(<?php echo json_encode($cgNoUtilizadas);?>,"cn")'>Ver más <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
            </div>

            <div class="box">
              <div class="box-body table-responsive" id="tabla">
              </div>
            </div>
        </section>
      </div>
    </div>
    <!-- ./wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="../js/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../js/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../datatables/jquery.dataTables.min.js"></script>
    <script src="../datatables/dataTables.bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../js/app.min.js"></script>
    <!-- Tabla principal -->
    <script src="../js/V1/tablaprincipal.js"></script>

</body>
</html>
