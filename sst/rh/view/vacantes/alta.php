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
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="Maria de los Angeles Malagon, Salvador Luna, Victor Nava y Gerardo Medina">
  <title>Nombre del Módulo | Spar México</title>
  <!-- Indicadores para respuestas de la plantilla -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/start/jquery-ui.css">
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
        <a href="#" class="logo">
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
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
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
                  <a href="<a href="../controller/indexControlador.php?urlValue=logout" class="btn btn-default btn-flat">Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </li>
        <!-- Botón superior derecho asignado al control de la barra lateral -->
            <!--  <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li> -->
        </ul>
      </div>
    </nav>
  </header>
  <!--**** Columna del lado izquierdo. Contiene el logotipo y la barra lateral**** -->
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

      <!-- Comienza barra de menus: : Estilos encontrados en Less -->
        <ul class="sidebar-menu">


      <!-- Barra de separación entre menus -->
        <li class="header">Opciones</li>
      <!-- Fin de la barra de separación entre menus -->
      <li>
              <a href="crudIndex.php?urlValue=login">
                <i class="fa fa-arrow-left"></i> <span>Regresar</span>
              </a>
            </li>
    </section>
    <!-- Termina barra de menus -->
  </aside>     
             
<!--**************Empieza la parte del panel***********************-->
<div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- right column -->
            <div class="col-md-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Solicitud de Vacantes</h3>

                </div>
                  <!--Empieza la parte del formulario y codigo de php-->
                  <div class="box-body">
                  <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                  <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                    <div class="col-md-12">
                        <div class="alert alert-<?php echo $clase;?>" >
                          <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                          <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                        </div>
                    </div>
                  </div>
                  <!--**************Empiezan los radiobuttons***********************-->
                  <div class="form-group">
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="Cliente" value="option1">
                      Cliente
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="Administrativo" value="option2">
                      Administrativo
                    </label>
                     </div>
                     <!--Termina los radiobuttons-->
                     <!--************************Opcion del Cliente**********************-->
                  <div class="col-md-12">
                      <div class="tab-content">
                        <div id="Cliente" class="tab-pane active schedule-pane">
                          <form data-toggle="validator" method="POST" role="form" action="crudVacantes.php?accion=guardar">                     
                            <!--***En esta parte se vera la caja de texto de la fecha de solicitud***-->
                            <div class="form-group col-md-4">
                              <label class="control-label">Fecha:</label>
                              <div class="input-group date">
                              <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                              </div>
                              <input type="Date" name="Fecha" class="form-control input-sm" data-error="Es un campo obligatorio" required>
                              <div class="help-block with-errors"></div>
                            </div>                            
                            </div>
                            <!--***Termina la caja de texto de fecha de solictud***-->                           
                             <!--***Empiezan el combo box de puesto-->
                            <div class="form-group col-md-4">
                              <label class="control-label">Puesto:</label>
                              <select class="form-control input-sm selectpicker" name ="Puesto" data-error="Es un campo obligatorio" data-live-search="true" required>
                              <option value="saab">Promotor</option>                              
                              </select>
                              </div>
                              <!--Termina el combo box de puesto-->                      
                             <!--***Empieza la caja de texto de cuenta***-->
                            <div class="form-group col-md-2">
                              <label class="control-label">Cuenta:</label>
                              <input type="text" name="Cuenta" class="form-control input-sm" data-error="Es un campo obligatorio" required>
                              <div class="help-block with-errors"></div>
                            </div>
                            <!--***Termina la caja de texto decuenta***--> 
                            <!--***Empiezan el combo box de puesto-->
                            <div class="form-group col-md-2">
                              <label class="control-label">Sueldo:</label>
                              <input type="text" name="Cuenta" class="form-control input-sm" data-error="Es un campo obligatorio" required>
                              <div class="help-block with-errors"></div>
                              </div>
                              <!--Termina el combo box de puesto-->                             
                             <!--***Empiezan el combo box de puestos-->
                            <div class="form-group col-md-4">
                              <label class="control-label">Region:</label>
                              <select class="form-control input-sm selectpicker" name="Region" data-error="Es un campo obligatorio" data-live-search="true" required> 
                              <option value="volvo">Norte</option>
                              <option value="saab">Sur</option>
                              <option value="opel">Este</option>
                              <option value="audi">Oeste</option>                            
                              </select>
                              </div>
                              <!--Termina el combo box de puesto-->                               
                              <!--***Empiezan el combo box de estado-->
                            <div class="form-group col-md-4">
                              <label class="control-label">Estado:</label>
                              <select class="form-control input-sm selectpicker" name="Estado" data-error="Es un campo obligatorio" data-live-search="true" required>
                              <option value="saab">CDMX</option> 
                              </select>
                              </div>
                              <!--Termina el combo box de estado--> 
                               <!--***Empiezan el combo box de delegacion-->
                            <div class="form-group col-md-4">
                              <label class="control-label">Delegacion/Municipio:</label>
                              <select class="form-control input-sm selectpicker" name="Delegacion" data-error="Es un campo obligatorio" data-live-search="true" required>
                              <option value="saab">Alvaro Obregon</option>
                              </select>
                              </div>
                              <!--Termina el combo box de delegacion-->  
                            <div class="form-group col-md-12">
                              <div class="form-group">
                              <label>Requerimientos</label>
                              <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                              </div>                                            
                          </form>  
                          <div class="box-footer col-md-12">  
                              <button type="submit" class="btn btn-link" id="vacante">+Agregar Vacante</button>                
                              <button type="button" class="btn btn-success pull-right">Guardar</button>                                
                            </div>                                                                                                 
                        </div>
                      </div>                      
                    </div>
                  </div>
              </div>
            </div>             
          </div>
        </section>        
<!--**************Termina la parte del panel**********************-->


       </div>

      <!-- Inicio del pie de página -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Versión</b> 1.0.0
        </div>
        Todos los derechos reservados 2017 - <strong>Título del Módulo</strong> | Spar Todopromo, SAPI de C.V.
      </footer>
    <!-- Fin del pie de página -->
    <!-- ./wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!--********Para empezar agregar mas formularios***********-->
    <!-- jQuery UI 1.11.4 -->
    <script src="../../assets/js/jquery/jquery-ui.js"></script>   
    <script>
      
        $(function(){
        // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
        $("#vacante").on('click'), function(){
          $("#Cliente").clone().removeClass('fila-fija').appendTo("#Cliente");
        });               
      });
    </script> 
         <!-- Bootstrap 3.3.6 -->
    <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../assets/js/app.min.js"></script>
    <!-- Index Módulo Administrativo -->
    <script src="../js/V1/index.js"></script>
  </body>
</html>