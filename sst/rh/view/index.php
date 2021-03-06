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
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <!-- Fuentes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet" href="../assets/css/morris/morris.css">
  <!-- Estilo del tema -->
  <link rel="stylesheet" href="../assets/css/AdminLTE.min.css">
  <!-- Poner la carpeta de estilo CSS a utilizar-->
  <link rel="stylesheet" href="../assets/css/_all-skins.min.css">
  <!-- selected -->
  <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap-select.min.css">
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
                <li><a href="view/conocimientos/index.php?accion=index"><i class="fa  fa-graduation-cap"></i> Conocimientos</a></li>
                <li><a href="view/habilidades/index.php?accion=index"><i class="fa  fa-comment-o"></i> Habilidades</a></li>
                <li><a href="view/presupuestos/index.php?accion=index"><i class="fa fa-calculator"></i> Presupuestos</a></li>
                <li><a href="view/perfiles/index.php?accion=index"><i class="fa fa-user-plus"></i> Perfiles</a></li>
                <!-- <li><a href="view/salarios/index.php?accion=index"><i class="fa  fa-money"></i> Salarios</a></li> -->
              </ul>
            </li>
            <!-- Find e la barra de separación entre menus -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Solicitudes de Empleo</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="view/solicitudEmpleos/index.php?accion=index"><i class="fa fa-user-plus"></i>Principal</a></li>
              </ul>
            </li>
            <?php
            if(isset($permisosVacantes["Principal"]) && $permisosVacantes["Principal"] === "1" ){
            ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-black-tie"></i> <span>Vacantes</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="view/vacantes/index.php?accion=index"><i class="fa fa-circle-o"></i> Principal</a></li>
                <?php
                if(isset($permisosVacantes["Procesar"]) && $permisosVacantes["Procesar"] === "1"){
                ?>
                <li><a href="view/vacantes/index.php?accion=indexProcesar"><i class="fa fa-spinner"></i> Procesar</a></li>
                <?php
                }
                ?>
              </ul>
            </li>
            <?php
            }
            ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-black-tie"></i> <span>Prospectos</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="view/prospectos/index.php?accion=index"><i class="fa fa-circle-o"></i> Vacante</a></li>
                <li><a href="view/prospectos/index.php?accion=indexSolicitudes"><i class="fa fa-spinner"></i> Solicitudes</a></li>
              </ul>
            </li>
            <!--
            <li class="treeview">
              <li><a href="../view/representantes/index.php?accion=index"><i class="fa fa-user"></i> Representante</a></li>
            </li>
          -->
            <!-- <li class="treeview">
              <a href="#">
                <i class="fa fa-line-chart"></i> <span>Reportes</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="view/vacantes/index.php?accion=index"><i class="fa fa-calendar"></i> Semanal</a></li>
              </ul>
            </li> -->
             
            <!-- Barra de separación entre menus -->
            <li class="header"></li>
            <!-- Find e la barra de separación entre menus -->
            <li>
              <a href="../index.php">
                <i class="fa fa-hand-o-left"></i> <span>Regresar</span>
              </a>
            </li>
          </ul>
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
            <!-- <li><a href="#"><i class="fa fa-sign-in"></i> Inicio</a></li> -->
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- BAR CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <div class="col-md-6">
                <div class="col-md-7">
                  <small><?php echo "Elaboración: $calculado";?></small>
                </div>
                <div class="col-md-5 text-center">
                  <strong>Movimientos <?php echo $tmp;?></strong>
                </div>
              </div>
              <div class="col-md-6">
                <form action="index.php?accion=index" method="POST">
                  <div class="row">
                    <div class="col-md-7">
                      <select class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" data-live-search="true" data-size="5" name="clientes[]" id="cliente" multiple="multiple" data-container="body"  data-live-search = "true" data-selected-text-format="count > 5">
                        <?php
                        foreach ($clientes as $cliente) {
                        ?>
                        <option value="<?php echo base64_encode($cliente['idclientes'])?>" <?php if(isset($tmpClientes)) if (in_array(base64_encode($cliente['idclientes']), array_column($tmpClientes, "idclientes"))) echo "selected";?>><?php echo $cliente["nombreComercial"];?></option>
                        <?php 
                        }
                      ?> 
                      </select>
                    </div>
                    <div class="col-md-3">
                      <select class="form-control input-sm selectpicker" name="g">
                        <option <?php if($txtBoton == "Diario") echo "selected";?>>Diario</option>
                        <option <?php if($txtBoton == "Semanal") echo "selected";?>>Semanal</option>
                        <option <?php if($txtBoton == "Mensual") echo "selected";?>>Mensual</option>
                        <option <?php if($txtBoton == "Anual") echo "selected";?>>Anual</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <button type="submit" class="btn btn-flat btn-info btn-sm btn-block"><i class="fa fa-fw fa-bar-chart"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <div id="bar-chart" ></div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </section>
      </div>
      <!-- /.content-wrapper -->
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
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../assets/js/morris/morris.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/js/app.min.js"></script>
    <!-- Bootstrap select js -->
    <script src="../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../assets/js/funciones.js"></script>
    <!-- Index Módulo Administrativo -->
    <script src="js/V1/index.js"></script>
    <script>
      $(function () {
        "use strict";
        //BAR CHART
        var bar = new Morris.Bar({
          element: 'bar-chart',
          data: [
          <?php
          $j = 0;
          for($i = 1; $i <= count($ejeX); $i++) {
            // echo $vacantes[$j]["ejeX"];
            if(isset($vacantes[$j]["ejeX"])){
              if($i == $vacantes[$j]["ejeX"]){
                $tmpA = $vacantes[$j]["búsqueda"];
                $tmpB = $vacantes[$j]["canceladas"];
                $tmpC = $vacantes[$j]["cubiertas"];
                $tmpD = $vacantes[$j]["proceso"];
                $tmpE = $vacantes[$j]["solicitadas"];
                $j++;
              }
              else{
                $tmpA = 0;
                $tmpB = 0;
                $tmpC = 0;
                $tmpD = 0;
                $tmpE = 0;
              }
            }
            else{
              $tmpA = 0;
              $tmpB = 0;
              $tmpC = 0;
              $tmpD = 0;
              $tmpE = 0;
            }
          ?>
            {y: '<?php echo $ejeX[$i];?>', a: <?php echo $tmpA;?>, b: <?php echo $tmpB;?>, c: <?php echo $tmpC;?>, d: <?php echo $tmpD;?>, e: <?php echo $tmpE;?>},
          <?php
          }
          ?>
          ],
          // numLines: 5,
          barColors: ['#00c0ef', '#dd4b39', '#00a65a', '#f39c12', '#3c8dbc'],
          xkey: 'y',
          ykeys: ['a', 'b', 'c', 'd', 'e'],
          labels: ['Búsqueda', 'Canceladas', 'Cubiertas', 'Proceso', 'Solicitadas'],
          hideHover: 'auto'
        });
      });
    </script>
  </body>
</html>