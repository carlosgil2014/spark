<?php
    if(!isset($_SESSION['spar_usuario']))
       header('Location: ../../index.php?accion=index'); 
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
   <!-- Bootstrap select -->
  <link rel="stylesheet" href="../../../assets/css/bootstrap/bootstrap-select.min.css">
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
        <a href="../../index.php?accion=index" class="logo">
          <!-- El mini logo es para la barra lateral y está como mini 50x50 pixels -->
          <span class="logo-mini"><b>ST</b></span>
          <!-- logotipo para el estado normal y dispositivos móviles  -->
          <span class="logo-lg">Sistemas | Spar</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <?php 
          include_once("../../../view/includes/datosUsuario.php");
        ?>
    </header>
  <!-- Columna del lado izquierdo. Contiene el logotipo y la barra lateral -->
    <aside class="main-sidebar">
      <!-- Barra lateral: Este estilo se puede encontrar en sidebar.less -->
      <section class="sidebar">
       
        <?php 
              include_once("../../../view/includes/menuIzquierdo.php");
        ?>
        <ul class="sidebar-menu">
              <!-- <li class="header">Solicitudes</li> -->
              <li>
                <a href="../../index.php?accion=index">
                  <i class="fa fa-arrow-left"></i> <span>Regresar</span>
                </a>
              </li>
        </ul>
                
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
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Empleados</h3>
            </div>
           
            <!-- /.box-header -->

              <?php 
              if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}
              ?>

              <!-- Avisos  -->
              <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                <div class="col-md-4 col-md-offset-4">
                  <div class="alert alert-<?php echo $clase;?>" >
                    <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                    <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                  </div>
                </div>
              </div>
              <!-- Fin Avisos -->

              <div class="row">
                <div class="col-md-12">
                  <div class="nav-tabs-custom">  
                    <ul class="nav nav-tabs">
                      <li class="active"><a data-toggle="tab" href="#activos">Activos</a></li>
                      <li><a data-toggle="tab" href="#bajas">Bajas</a></li>
                    </ul>

                    <div class="tab-content">
                    
                      <div id="activos" class="tab-pane fade in active">
                        
                          <div class="page-header"> 
                           <button type="button" class="btn btn-success btn-flat btn-sm" onclick="consultar();">Agregar</button>
                          </div>                          

                          <table id="tblContraseniasActivos" class="table table-bordered table-striped small">
                            <thead>
                            <tr>
                              <th>Nombre</th>
                              <th>Correo Agencia</th>
                              <th>Contraseña computadora</th>
                              <th>Contraseña correo</th>
                              <th>Expira</th>
                              <th>Editar</th>    
                                             
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
                                  <a href="#">
                                    <i class="fa fa-edit" onclick="editar('<?php echo $empleado['empleados_id']; ?>','<?php echo $empleado['nombre']; ?>','<?php echo $empleado['correoagencia']; ?>','<?php echo $empleado['contraseniacomp']; ?>','<?php echo $empleado['contraseniacorreo']; ?>','<?php echo $empleado['expiracion']; ?>');"></i>
                                  </a>
                                </td>
                                
                              </tr>
                              <?php
                              }
                              ?>
                            </tbody>
                          </table>
                            
                      </div>
                      
                      <div id="bajas" class="tab-pane fade">
                        <div class="box-body table-responsive"> 
                          <table id="tblContraseniasBajas" class="table table-bordered table-striped small">
                            <thead>
                            <tr>
                              <th>Nombre</th>
                              <th>Correo Agencia</th>
                              <th>Contraseña computadora</th>
                              <th>Contraseña correo</th>
                              <th>Expira</th>
                                              
                            </tr>
                            </thead>
                            
                            <tbody>
                              <?php 
                              foreach($empleadosBaja as $empleado){
                              ?>
                              <tr>
                                <td><?php echo $empleado['nombre']; ?></td>
                                <td><?php echo $empleado['correoagencia']; ?></td>
                                <td><?php echo $empleado['contraseniacomp']; ?></td>
                                <td><?php echo $empleado['contraseniacorreo']; ?></td>
                                <td><?php if($empleado['expira']<1) echo "Expirado"; else echo $empleado['expira'] . " días"; ?></td>
                                
                                
                              </tr>
                              <?php
                              }
                              ?>
                            </tbody>
                          </table>
                        </div><!-- /.box-body --> 
                      </div>
                    </div>

                  </div>  
                </div>
              </div> <!--row--> 
                  
            
          </div>
          <!-- /.box -->
          </section>
      </div>
      <!-- Termina el contenido general de la página -->
      
      <!-- ************** Modal ************* -->
      <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        
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
    <!-- Validaciones -->
    <script src="../../../assets/js/validacion/validacion.js"></script>
    
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- DataTables -->
    <script src="../../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <script src="../../../assets/js/funciones.js"></script>
    <!-- Bootstrap select js -->
    <script src="../../../assets/js/bootstrap/bootstrap-select.min.js"></script>
           
    <!-- Index Módulo Administrativo -->
    <script src="../../js/V1/index.js"></script>
    <script src="../../js/V1/contrasenias/index.js"></script>
    <!-- index Contrasenias -->
    
  </body>
</html>