<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: index.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="Maria de los Angeles Malagon, Salvador Luna, Victor Nava y Gerardo Medina">
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
  <!-- DataTables -->
  <link rel="stylesheet" href="../assets/css/datatables/dataTables.bootstrap.css">
  <!-- Estilo del tema -->
  <link rel="stylesheet" href="../assets/css/AdminLTE.min.css">
  <!-- Bootstrap select -->
  <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap-select.min.css">
  <!-- Poner la carpeta de estilo CSS a utilizar-->
  <link rel="stylesheet" href="../assets/css/_all-skins.min.css">
  <!-- Soporte de elementos HTML5 para Respond.js, IE8 y media queries -->
  <!-- ADVERTENCIA: Respond.js no funcionará si se visualiza con IE 9:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
  <body class="hold-transition fixed skin-blue sidebar-mini">
    <div class="loader">
    </div>
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="../index.php" class="logo">
          <!-- El mini logo es para la barra lateral y está como mini 50x50 pixels -->
          <span class="logo-mini"><b>SRS</b></span>
          <!-- logotipo para el estado normal y dispositivos móviles  -->
          <span class="logo-lg">SRS</span>
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
          <!-- Comienza barra de menus: : Estilos encontrados en Less -->
          <ul class="sidebar-menu">
            <!-- Barra de separación entre menus -->
            <!-- <li class="header">Solicitudes</li> -->
            <!-- Fin de la barra de separación entre menus -->
            <?php 
            if($resultados["cotizaciones"]["crear"] == 1){
            ?>
            <li>
              <a style="cursor: pointer;"> 
                <i class="fa fa-circle-o"></i> <span>Cotizaciones</span>
              </a>
            </li>
            <?php
            }
            if($resultados["ordenes"]["crear"] == 1){
            ?>
            <li>
              <a style="cursor: pointer;"> 
                <i class="fa fa-circle-o"></i> <span>Ordenes de servicio</span>
              </a>
            </li>
            <?php
            }
            if($resultados["prefacturas"]["crear"] == 1){
            ?>
            <li>
              <a style="cursor: pointer;"> 
                <i class="fa fa-circle-o"></i> <span>Prefacturas</span>
              </a>
            </li>
            <li>
              <a style="cursor: pointer;"> 
                <i class="fa fa-circle-o"></i> <span>Conciliaciones</span>
              </a>
            </li>
            <?php
            }
            if($resultados["ordenes"]["crear"] == 1){
            ?>
            <li>
              <a style="cursor: pointer;" href="view/devoluciones/index.php?accion=listaClientes"> 
                <i class="fa fa-circle-o"></i> <span>Devoluciones</span>
              </a>
            </li>
            <?php
            }
            if($resultados["reportes"]["crear"] == 1){
            ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Reportes</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> General</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Ventas</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Facturación</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Total</a></li>
              </ul>
            </li>
            <?php
            }
            ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-circle-o"></i> <span>OS's Por Facturar</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li onclick="saldosPorFacturar(this,'16');">
                  <a href="#"><i class="fa fa-circle-o"></i>2016
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i><b></b></a></li>
                  </ul>
                </li>
                <li onclick="saldosPorFacturar(this,'17');">
                  <a href="#"><i class="fa fa-circle-o"></i>2017
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i><b></b></a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-circle-o"></i> <span>OS's Por Realizar</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li onclick="osPorRealizar(this,'16');">
                  <a href="#"><i class="fa fa-circle-o"></i>2016
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i><b></b></a></li>
                  </ul>
                </li>
                <li onclick="osPorRealizar(this,'17');">
                  <a href="#"><i class="fa fa-circle-o"></i>2017
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i><b></b></a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <?php
            if($resultados["conceptos"]["crear"] == 1){
            ?>
            <li>
              <a style="cursor: pointer;"> 
                <i class="fa fa fa-cogs"></i> <span>Parámetros del Módulo</span>
              </a>
            </li>
            <?php
            }
            ?>
          </ul>
        </section>
        <!-- Termina barra de menus -->
      </aside>
      <!-- Contenido de la página -->
      <div class="content-wrapper">
        <!-- Titulo para encabezado de la pantalla central -->
        <section class="content-header">
          <h1>
          Módulo Operativo
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
            <form method="POST" id="formPrincipal" action="index.php?accion=index" >
              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <select name="Datos[idCliente][]" class="form-control input-sm btn-flat" id="clientes" multiple="multiple" data-selected-text-format="count > 2" data-live-search = "true">
                <?php 
                  foreach ($datosClientes as $cliente) {
                  ?>
                  <option value="<?php echo $cliente['idclientes']?>" <?php if(isset($idClientes)) if (in_array($cliente['idclientes'], $idClientes)) echo "selected";?>><?php echo $cliente["nombreComercial"]." - ".$cliente["razonSocial"];?></option>
                  <?php 
                  }
                ?> 
                </select>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <label>De </label>
                <input type="date" value="<?php if(isset($fechaInicial))echo $fechaInicial; else echo $fecha;?>" class="form-control input-sm btn-flat" name="Datos[fechaInicial]">
              </div>
              <div class="form-group col-md-2 col-sm-5 col-xs-10">
                <label>Hasta </label>
                <input type="date" value="<?php if(isset($fechaFinal))echo $fechaFinal; else echo $fecha;?>" class="form-control input-sm btn-flat" name="Datos[fechaFinal]">
              </div>
              <div class=" form-group col-sm-1 col-xs-2">
                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <button type="submit" class="btn btn-info pull-right btn-sm btn-flat">Buscar</button>
              </div>
            </form>
          </div>
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <a class="small-box-footer">
                  Cotizaciones
                </a>
                <div class="inner">
                  <p onclick="tablaPrincipal('Cotizaciones','Por autorizar')" style="cursor: pointer;">En revisión 
                    <span class="pull-right"><?php echo $datosCount["cotPA"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Cotizaciones','Autorizada')" style="cursor: pointer;">Autorizadas
                    <span class="pull-right"><?php echo $datosCount["cotA"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Cotizaciones','Rechazada')" style="cursor: pointer;">Rechazadas 
                    <span class="pull-right"><?php echo $datosCount["cotR"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Cotizaciones','Cancelada')" style="cursor: pointer;">Canceladas
                    <span class="pull-right"><?php echo $datosCount["cotC"];?></span>
                  </p>
                </div>
                <!-- <div class="icon">
                  A
                </div> -->
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <a class="small-box-footer">
                  Ordenes de Servicio
                </a>
                <div class="inner">
                  <p onclick="tablaPrincipal('Ordenes','Por autorizar')" style="cursor: pointer;">En revisión 
                    <span class="pull-right"><?php echo $datosCount["ordPA"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Ordenes','Autorizada')" style="cursor: pointer;">Autorizadas
                    <span class="pull-right"><?php echo $datosCount["ordA"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Ordenes','Cancelada')" style="cursor: pointer;">Canceladas 
                    <span class="pull-right"><?php echo $datosCount["ordC"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Ordenes','Devolucion')" style="cursor: pointer;">Devoluciones
                    <span class="pull-right"><?php echo $datosCount["dev"];?></span>
                  </p>
                </div>
               <!--  <div class="icon">
                  B
                </div> -->
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <a class="small-box-footer">
                  Prefacturas
                </a>
                <div class="inner">
                  <p onclick="tablaPrincipal('Prefacturas','Por facturar')" style="cursor: pointer;">Por facturar
                    <span class="pull-right"><?php echo $datosCount["pfPF"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Prefacturas','Facturada')" style="cursor: pointer;">Facturadas
                    <span class="pull-right"><?php echo $datosCount["pfF"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Prefacturas','Cancelada')" style="cursor: pointer;">Canceladas 
                    <span class="pull-right"><?php echo $datosCount["pfC"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Prefacturas','Conciliado')" style="cursor: pointer;">Conciliadas
                    <span class="pull-right"><?php echo $datosCount["pfCl"];?></span>
                  </p>
                </div>
               <!--  <div class="icon">
                  D
                </div> -->
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <a class="small-box-footer">
                  Facturas
                </a>
                <div class="inner">
                  <p onclick="tablaPrincipal('Cobrado','Nopagado')" style="cursor: pointer;">No Pagadas 
                    <span class="pull-right"><?php echo $datosCount["facNP"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Cobrado','Parcialmente')" style="cursor: pointer;">Parcialmente Pagadas
                    <span class="pull-right"><?php echo $datosCount["facPP"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Cobrado','Pagado')" style="cursor: pointer;">Pagadas 
                    <span class="pull-right"><?php echo $datosCount["facP"];?></span>
                  </p>
                  <p onclick="tablaPrincipal('Cobrado','Cancelada')" style="cursor: pointer;">Canceladas
                    <span class="pull-right"><?php echo $datosCount["pfC"];?></span>
                  </p>
                </div>
               <!--  <div class="icon">
                  C
                </div> -->
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- ./row -->
          <div class="box">
            <div class="box-header">
              <h4 id="tituloTablaPrincipal"></h4>
            </div>
            <div class="box-body">
              <div class="table-responsive container-fluid row small" id="COPC">
              </div>
            </div>
          </div>
          <!-- ./box-body table-responsive container-fluid row -->
        <!-- ./col -->
        </section>
      </div>
      <!-- /.content-wrapper -->
      <div id="modalMotivo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="folio"></h4>
            </div>
            <div class="modal-body text-center">
              <textarea style="resize:none;" id="motivoText" class="form-control input-sm"></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" id="cancelar" class="btn btn-flat btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
              <button type="button" id="continuar" class="btn btn-flat btn-sm btn-primary" data-dismiss="modal">Continuar</button>
            </div>
          </div>
        </div>
      </div>
      <div id="modalIndex" class="modal fade" role="dialog">
      </div>
      <!-- /.modal -->

      <!-- Termina el contenido general de la página -->
      
      <!-- Inicio del pie de página -->
      <?php
        include_once("../view/includes/footer.php");
      ?>
      <!-- Fin del pie de página -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../assets/js/jquery/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../assets/js/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- DataTables -->
    <script src="../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/js/app.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../assets/js/funciones.js"></script>
    <!-- Bootstrap select js -->
    <script src="../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Index MRS -->
    <script src="js/V1/principal/indexV1.1.2.js"></script>
    <!-- Modal COT -->
    <script src="js/V1/cotizaciones/modalindexcot.js"></script>
    <!-- Modal OS -->
    <script src="js/V1/ordenesdeservicio/modalindexord.js"></script>
    <!-- Index PF -->
    <script src="js/V1/prefacturas/modalindexprefactura.js"></script>
    <!-- Index PF (CFDI) -->
    <script src="js/V1/facturas/modalindexfacturas.js"></script>
    <!-- Ordenar js -->
    <script src="../assets/js/ordenamiento/natural.js"></script>

  </body>
</html>