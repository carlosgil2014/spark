<?php
    if(!isset($_SESSION['spar_usuario']))
         header('Location: ../index.php');
    //Poner sesiones principales 

if(isset($_GET["estado"])){
  switch ($_GET["estado"]) {
    case '1':
      $claseMexico = "active";
      $claseCentro = "";
      $clasePacfifico = "";
      $claseNorte = "";
      $claseSur = "";
      $clasecliente = "";
      $claseCliente = "";
      break;
    case '2':
      $claseMexico = "";
      $claseCentro = "active";
      $clasePacfifico = "";
      $claseNorte = "";
      $claseSur = "";
      $clasecliente = "";
      $claseCliente = "";
      break;
    case '3':
      $claseMexico = "";
      $claseCentro = "";
      $clasePacfifico = "active";
      $claseNorte = "";
      $claseSur = "";
      $clasecliente = "";
      $claseCliente = "";
      break;
      case '4':      
      $claseMexico = "";
      $claseCentro = "";
      $clasePacfifico = "";
      $claseNorte = "active";
      $claseSur = "";
      $clasecliente = "";
      $claseCliente = "";
      break;
      case '5':
      $claseMexico = "";
      $claseCentro = "";
      $clasePacfifico = "";
      $claseNorte = "";
      $claseSur = "active";
      $clasecliente = "";
      $claseCliente = "";
      break;

      case '6':
      $claseMexico = "";
      $claseCentro = "";
      $clasePacfifico = "";
      $claseNorte = "";
      $claseSur = "";
      $clasecliente = "active";
      $claseCliente = "";
      break;

      case '7':
      $claseMexico = "";
      $claseCentro = "";
      $clasePacfifico = "";
      $claseNorte = "";
      $claseSur = "";
      $clasecliente = "";
      $claseCliente = "active";
    
    default:
      $claseMexico = "active";
      $claseCentro = "";
      $clasePacfifico = "";
      $claseNorte = "";
      $claseSur = "";
      $clasecliente = "";
      $claseCliente = "";
      break;
  }
}
else{
      $claseMexico = "active";
      $claseCentro = "";
      $clasePacfifico = "";
      $claseNorte = "";
      $claseSur = "";
      $clasecliente = "";
      $claseCliente = "";

}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon" />
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="Maria de los Angeles Malagon, Salvador Luna, Victor Nava y Gerardo Medina">
  <title>Sistema Spar Todopromo | Spar México</title>
  <!-- Indicadores para respuestas de la plantilla -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <!-- Fuentes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
   <!-- DataTables -->
  <link rel="stylesheet" href="../../assets/css/datatables/dataTables.bootstrap.css">
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
        <a href="../index.php?accion=login" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>ST</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Spar Todopromo</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <?php 
          include_once("../includes/datosUsuario.php");
        ?>
  </header>
  <!-- Columna del lado izquierdo. Contiene el logotipo y la barra lateral -->
  <aside class="main-sidebar">
    <!-- Barra lateral: Este estilo se puede encontrar en sidebar.less -->
    <section class="sidebar">
          <?php 
            include_once("../includes/menuIzquierdo.php");
          ?>

      <!-- Comienza barra de menus: : Estilos encontrados en Less -->
        <ul class="sidebar-menu">


      <!-- Barra de separación entre menus -->
        <li class="header">baja</li>
      <!-- Fin de la barra de separación entre menus -->
            <li>
              <a href="../../index.php?accion=index">
                <i class="fa fa-hand-o-left"></i> <span> Regresar</span>
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
          
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Index</a></li>
          </ol>
          <div class="row">
            <!-- right column -->
            <div class="col-md-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h2 class="box-title">Bajas del directorio telefónico</h2>
                </div>
                <!-- /.box-header -->
                <div id="respuesta"></div>
                <div class="box-body table-responsive">
                  <?php if(!isset($_SESSION["spar_error"])){$estilo = "style='display:none;'";}else{$estilo = "";}?>
                  <div class="row">
                    <div class="form-group" id="div_alert" <?php echo $estilo;?>>
                      <div class="col-md-4 col-md-offset-4">
                        <div class="alert alert-success" >
                          <strong>¡Aviso!</strong> <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a>
                          <br><p id="p_alert"><?php if(isset($_SESSION["spar_error"]))echo $_SESSION["spar_error"];?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--TABS-->
                  <table id="tblclaseMexico" class="table table-bordered table-striped small">
                          <thead>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono </th>
                            <th>Extensión</th>
                            <th>Región</th>
                            <th>Fecha de baja</th>
                            <th>Dias restantes</th>
                          </thead>
                                                
                          <tbody>
                          <?php 
                          foreach($bajas as $baja){
                          ?>                         
                          <tr>
                            <td><?php echo $baja["empleados_nombres"]." ".$baja['empleados_apellido_paterno']." ".$baja['empleados_apellido_materno']?></td>
                            <td><?php if(!$baja['empleados_correo']){ echo 'sin correo'; } else{ echo $baja['empleados_correo']; }?></td>
                            <td><?php 
                            if (!empty($baja['telefono'])) { 
                                echo $baja['telefono'];   
                             }elseif(!empty($baja['telefonoSecundario'])){
                                echo $baja['telefonoSecundario'];
                             }elseif(!empty($baja['telefonoAlterno'])){
                                echo $baja['telefonoAlterno'];
                             }elseif($baja['telefonoCasa']){
                                echo $baja['telefonoCasa'];
                             }else{
                                echo "no hay telefonos";
                             }
                             
                            ?></td>
                            <td><?php echo $baja['telefonoExtencion']; ?></td>
                            <td><?php if ($baja['region'] == 'CDMX') {
                              echo 'Centro';
                            }else{
                             echo $baja['region']; 
                            }?>
                            <td><?php echo $baja['empleados_fecha_baja'];?></td>
                            <td><?php echo $baja['diasRestantes'];?> </td>
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
            </div>
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </section>      

        <!-- ./col -->
</div>
      <!-- Termina el contenido general de la página -->
      
      <!-- Inicio del pie de página -->
      <?php
      include_once("../../view/includes/footer.php");
      ?>

            <div class="modal fade" id="modalModificar" role="dialog">
            </div>

    <!-- Modal Eliminar -->
      <div id="modalEliminar" class="modal fade" role="dialog">
        <div class="modal-dialog modal-">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Eliminar</h4>
            </div>
            <div class="modal-body text-center">
            ¿Quiere quitar a este empleado del baja telefónico?<b id="categoriaEliminar"></b>
            </div>
            <div class="modal-footer">
              <button type="button" id="eliminar" class="btn btn-sm btn-success" data-dismiss="modal">Si</button>
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Eliminar -->
    <!-- Fin del pie de página -->
    <!-- ./wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../assets/js/jquery/jquery-ui.js"></script>
    <!-- DataTables -->
    <script src="../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="../../assets/js/input-mask/jquery.inputmask.js"></script>
    <!-- Validaciones -->
    <script src="../../assets/js/validacion/validacion.js"></script>   
    <!--Funciones Generales-->
    <script src="../../assets/js/funciones.js"></script>
    <!-- AdminLTE App -->
    <script src="../../assets/js/app.min.js"></script>
    <script src="../../js/V1/directorio/index.js"></script>
  </body>
</html>