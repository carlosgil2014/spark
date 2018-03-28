<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: ../../../view/index.php?accion=login');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../../../img/favicon.ico" type="image/x-icon" />
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
    <div class="">
    </div>
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="../../../index.php" class="logo">
          <!-- El mini logo es para la barra lateral y está como mini 50x50 pixels -->
          <span class="logo-mini"><b>ST</b></span>
          <!-- logotipo para el estado normal y dispositivos móviles  -->
          <span class="logo-lg">Spar Todopromo</span>
        </a>
        <!-- La cabecera Navbar: Este estilo se puede encontrar en header.less -->
        <?php 
          include_once("../../../view/includes/datosUsuario.php");
        ?>
      </header>
      <!-- Columna del lado izquierdo. Contiene el logotipo y la barra lateral -->
      <aside class="main-sidebar">
        <!-- Barra lateral: Este estilo se puede encontrar en sidebar.less -->
        <section class="sidebar">
          <!-- Panel de usuario de la barra lateral -->
          <?php 
            include_once("../../../view/includes/menuIzquierdo.php");
          ?>
          <!-- Comienza barra de menus: : Estilos encontrados en Less -->
          <ul class="sidebar-menu">
          
            <li><a href="index.php?accion=nuevaOrden"><i class="fa fa-plus"></i>Nueva Orden</a></li>
        
        	<li>
              <a href="../../index.php">
                <i class="fa fa-hand-o-left"></i> <span>Regresar</span> 
              </a>
            </li>
          </ul>
        </section>
        <!-- Termina barra de menus -->
      </aside>
      <!-- Contenido de la página -->
      <div class="content-wrapper">
        <section class="content-header">
          <h4>
            Ordenes de compra
          </h4>
          <ol class="breadcrumb">
            <li><a href="index.php?accion=nuevaOrden"><i class="fa fa-plus-square"></i>Nueva Orden</a></li>
          </ol>
        </section>
    	
        <!-- Main content -->
        <section class="content">
          <div class="row">
          	<div class="col-xs-12">
          		<div class="box">
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                  <form id="formExportarCuentas" method="POST" action = "">
                    <table id="compras" class="table table-hover">
                      <thead>
                        <tr>
                          <th  >Folio solicitud</th>
                          <th  >Folio comprobado</th>
                          <th  >Empleado</th>
                          <th  >Observaciones</th>
                          <th  >Total</th>
                          <th  >Solicitante</th>
                          <th  >Fecha</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                          <td>5</td>
                          <td>7</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                          <td>5</td>
                          <td>7</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                          <td>5</td>
                          <td>7</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                          <td>5</td>
                          <td>7</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                          <td>5</td>
                          <td>7</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                          <td>5</td>
                          <td>7</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                          <td>5</td>
                          <td>7</td>
                          <td>8</td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                          <td>5</td>
                          <td>7</td>
                          <td>8</td>
                        </tr>
                      </tbody>
                    </table>
                  </form>
                </div>

                    <!-- /.box-body -->
                    
              </div>
          	</div>
          </div>
        <!-- ./col -->
        </section>

      </div><!-- /.content-wrapper -->
      

      <!-- Termina el contenido general de la página -->
      
      <!-- Inicio del pie de página -->
      <?php
        include_once("../../../view/includes/footer.php");
      ?>
      <!-- Fin del pie de página -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../../assets/js/jquery/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Index Módulo Administrativo -->
    <script src="../../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    
    <script src="../../js/V1/index.js"></script>
  </body>
</html>