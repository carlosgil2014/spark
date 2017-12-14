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
  <meta name="author" content="Maria de los Angeles Malagon, Salvador Luna, Victor Nava y Gerardo Medina">
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
        <a href="../../view/index.php" class="logo">
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
            <i class="fa fa-cog"></i> <span>Empleados</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../controller/crudProspecto.php?accion=alta"><i class="fa fa-user"></i>Alta-Empleado</a></li>
            <li><a href="../controller/crudProspecto.php?accion=modificar"><i class="fa  fa-edit"></i>Editar-Empleado</a></li>
          </ul>
        </li>

        <!-- Barra de separación entre menus -->
        <li class="header"></li>
        <!-- Find e la barra de separación entre menus -->
        
        <li>
          <a href="../../controller/crudIndex.php?urlValue=login">
            <i class="fa fa-hand-o-left"></i> <span>Regresar</span>
            
          </a>
        </li>

    </section>
    <!-- Termina barra de menus -->
  </aside>

<!-- Contenido de la página -->
<div class="content-wrapper">

  <section class="content">
    <div class="row">
            <!-- right column -->
      <div class="col-md-12">
              <!-- Horizontal Form -->
        <div class="box box-info">
          
          <div class="box-header with-border">
            <h3 class="box-title">Alta/Prospectos</h3>
          </div>
            
            <section class="content">

              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#1">Datos Personales</a></li>
                <li><a data-toggle="tab" href="#2">Documentacion</a></li>
                <li><a data-toggle="tab" href="#3">Salud y Habitos</a></li>
                <li><a data-toggle="tab" href="#4">Datos familiares</a></li>
                <li><a data-toggle="tab" href="#5">Escolaridad</a></li>
              </ul>
              
              <div class="tab-content">

                <div id="1" class="tab-pane active">
                  <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">CURP</label>
                        <input type="text" class="form-control">
                      </div>
                  </div>

                  <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Apellido Paterno</label>
                        <input type="text" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Apellido Materno</label>
                        <input type="text" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Nombre(s)</label>
                        <input type="text" class="form-control">
                      </div>
                       <div class="form-group col-md-3">
                        <label for="">Edad</label>
                        <input type="text" class="form-control">
                      </div>
                  </div>

                  <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">CP</label>
                        <input type="text" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Estado</label>
                        <input type="text" class="form-control">                
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Ciudad</label>
                        <input type="text" class="form-control">                
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Colonia</label>
                        <input type="text" class="form-control">
                      </div>
                  </div>

                  <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Telefono</label>
                        <input type="text" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Sexo</label>
                        <div class="radio">
                          <label class="radio-inline"><input type="radio" name="Sexo">Hombre</label>
                          <label class="radio-inline"><input type="radio" name="Sexo">Mujer</label>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Lugar de Nacimiento</label>
                        <input type="text" class="form-control">                
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Fecha de Nacimiento</label>
                        <input type="date" class="form-control">                
                      </div>
                  </div>

                  <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Nacionalidad</label>
                          <select name="nacionalidad" id="" class="form-control">
                            <option value="Mexicano">Mexicano(a)</option>
                            <option value="Extranjero">Extranjero(a)</option>
                          </select>  
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Estado Civil</label>
                        <div class="radio">
                          <label class="radio-inline"><input type="radio" name="EstadoCivil">Soltero(a)</label>
                          <label class="radio-inline"><input type="radio" name="EstadoCivil">Casado(a)</label>
                          <label class="radio-inline"><input type="radio" name="EstadoCivil">Otro</label>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Estatura</label>
                        <div class="input-group">
                          <input type="text" class="form-control">
                          <span class="input-group-addon">Mts.</span>                      
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Peso</label>
                        <div class="input-group">
                          <input type="text" class="form-control">
                          <span class="input-group-addon">Kg.</span>                      
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="form-group col-md-6">
                        <label for="">Vive con</label>
                        <div class="radio">
                          <label class="radio-inline"><input type="radio" name="vivecon">Padres</label>
                          <label class="radio-inline"><input type="radio" name="vivecon">Familia</label>
                          <label class="radio-inline"><input type="radio" name="vivecon">Parientes</label>
                          <label class="radio-inline"><input type="radio" name="vivecon">Solo</label>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Personas que dependen de usted</label>
                        <div class="checkbox">
                          <label class="checkbox-inline"><input type="checkbox" name="personas">Hijos</label>
                          <label class="checkbox-inline"><input type="checkbox" name="personas">Conyuge</label>
                          <label class="checkbox-inline"><input type="checkbox" name="personas">Padres</label>
                          <label class="checkbox-inline"><input type="checkbox" name="personas">Otros</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div id="2" class="tab-pane">

                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Afore</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label>RFC</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Numero Seguro Social</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label>N° Cartilla Militar</label>
                      <input type="text" class="form-control">
                    </div>
                  </div>  

                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>N° Pasaporte</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Tiene Licencia de manejo</label>
                      <div class="radio">
                        <label class="radio-inline"><input type="radio" name="licencia">Si</label>
                        <label class="radio-inline"><input type="radio" name="licencia">No</label>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Clase y N° de Licencia</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Documentos Extranjeros</label>
                      <input type="text" class="form-control">
                    </div>
                  </div>   
                </div>
                
                <div id="3" class="tab-pane">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label >¿Como considera su estado de salud?</label>
                      <div class="radio">
                        <label class="radio-inline"><input type="radio" name="salud">Bueno</label>
                        <label class="radio-inline"><input type="radio" name="salud">Regular</label>
                        <label class="radio-inline"><input type="radio" name="salud">Malo</label>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>¿Padece alguna enfermedad cronica?</label>
                      <div class="radio">
                        <label class="radio-inline"><input type="radio" name="enfermedad">No </label>
                        <label class="radio-inline"><input type="radio" name="enfermedad">Si </label>
                        <input type="text" placeholder="Explique">
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>¿Practica algun deporte?</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label>¿Pertenece algun club social?</label>
                      <input type="text" class="form-control">
                    </div>
                  </div>  
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label>¿Cual es su pasatiempo favorito?</label>
                        <input type="text" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label>¿Cual es su meta en la vida?</label>
                        <input type="text" class="form-control">
                      </div>
                    </div>  
                </div>

                <div id="4" class="tab-pane">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Nombre del padre</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-2">
                      <label>Vive / Finado</label>
                      <div class="radio">
                        <label class="radio-inline"><input type="radio"></label>
                        <label class="radio-inline"><input type="radio"></label>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Domicilio</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-3">
                      <label>Ocupacíon</label>
                      <input type="text" class="form-control">                      
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Nombre de la madre</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-2">
                      <label>Vive / Finado</label>
                      <div class="radio">
                        <label class="radio-inline"><input type="radio"></label>
                        <label class="radio-inline"><input type="radio"></label>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Domicilio</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-3">
                      <label>Ocupacíon</label>
                      <input type="text" class="form-control">                      
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Nombre de la esposa</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-2">
                      <label>Vive / Finado</label>
                      <div class="radio">
                        <label class="radio-inline"><input type="radio"></label>
                        <label class="radio-inline"><input type="radio"></label>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Domicilio</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-3">
                      <label>Ocupacíon</label>
                      <input type="text" class="form-control">                      
                    </div>
                  </div>
                </div>

                <div id="5" class="tab-pane">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Nombre Primaria</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-3">
                      <label>Direccíon</label>
                      <input type="text" class="form-control">                      
                    </div>  
                    <div class="form-group col-md-3">
                      <label>Periodo</label>
                      <div class="input-group">
                        <input type="text" class="form-control">  
                        <span class="input-group-addon">A</span>
                        <input type="text" class="form-control">
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Titulo recibido</label>
                      <input type="text" class="form-control">                      
                    </div>  
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Nombre Secundaria</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-3">
                      <label>Direccíon</label>
                      <input type="text" class="form-control">                      
                    </div>  
                    <div class="form-group col-md-3">
                      <label>Periodo</label>
                      <div class="input-group">
                        <input type="text" class="form-control">  
                        <span class="input-group-addon">A</span>
                        <input type="text" class="form-control">
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Titulo recibido</label>
                      <input type="text" class="form-control">                      
                    </div>  
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Nombre Prepa</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-3">
                      <label>Direccíon</label>
                      <input type="text" class="form-control">                      
                    </div>  
                    <div class="form-group col-md-3">
                      <label>Periodo</label>
                      <div class="input-group">
                        <input type="text" class="form-control">  
                        <span class="input-group-addon">A</span>
                        <input type="text" class="form-control">
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Titulo recibido</label>
                      <input type="text" class="form-control">                      
                    </div>  
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label>Profesional</label>
                      <input type="text" class="form-control">                      
                    </div>
                    <div class="form-group col-md-3">
                      <label>Direccíon</label>
                      <input type="text" class="form-control">                      
                    </div>  
                    <div class="form-group col-md-3">
                      <label>Periodo</label>
                      <div class="input-group">
                        <input type="text" class="form-control">  
                        <span class="input-group-addon">A</span>
                        <input type="text" class="form-control">
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Titulo recibido</label>
                      <input type="text" class="form-control">                      
                    </div>  
                  </div>
                </div>

              </div><!-- tab content-->  
               
              

            </section><!--content-->
                         
        </div><!-- fin class=box -->

      </div>  
           
    </div><!-- /.row -->
          
  </section><!-- content-->
</div><!-- /.content-wrapper --><!-- Termina el contenido general de la página -->

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
    <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../../assets/js/jquery/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- Index Módulo Administrativo -->
    <script src="../../js/V1/index.js"></script>
  </body>
</html>