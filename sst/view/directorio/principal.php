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
        <li class="header">Directorio</li>
      <!-- Fin de la barra de separación entre menus -->
            <li>
              <a href="index.php?accion=buscarEmpleado"><i class="fa fa-user-plus"></i><span> Agregar</span>
              </a>
              <a href="index.php?accion=bajasDirectorio"><i class="fa fa-user-times"></i><span> Bajas del directorio</span>
              </a>
              <a href="#"><i class="fa fa-question-circle"></i><span> Ayuda</span>
              </a>
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
                  <h2 class="box-title">Directorio Telefónico</h2>
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
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="<?php echo $claseMexico;?>"><a href="#tab_1" data-toggle="tab" aria-expanded="false" > Spar México</a></li>
                      <li class="<?php echo $claseProveedor;?>"><a href="#tab_2" data-toggle="tab" aria-expanded="false"> Proveedores</a></li>
                      <li class="<?php echo $claseCliente;?>"><a href="#tab_3" data-toggle="tab" aria-expanded="false"> Cliente</a></li>
                      <li class="<?php echo $claseRepresentante;?>"><a href="#tab_4" data-toggle="tab" aria-expanded="false"> Representantes</a></li>
                    </ul>
                    
                    <div class="tab-content">

                      <div class="tab-pane <?php echo $claseMexico;?>" id="tab_1">                          
                        <table id="tblclaseMexico" class="table table-bordered table-striped small">
                          <thead>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono </th>
                            <th>Extensión</th>
                            <th>Región</th>
                            <th></th>
                            <th></th>
                            <!--<th></th>-->
                          </thead>
                                                
                          <tbody>
                          <?php 
                          foreach($directorios as $directorio){
                          ?>                         
                          <tr>
                            <td><?php echo  ucwords(strtolower($directorio["empleados_nombres"]." ".$directorio['empleados_apellido_paterno']." ".$directorio['empleados_apellido_materno']))?></td>
                            <td><?php if(!$directorio['empleados_correo']){ echo 'sin correo'; } else{ echo $directorio['empleados_correo']; }?></td>
                            <td><?php 
                            if (!empty($directorio['telefono'])) { 
                                echo $directorio['telefono'];   
                             }elseif(!empty($directorio['telefonoSecundario'])){
                                echo $directorio['telefonoSecundario'];
                             }elseif(!empty($directorio['telefonoAlterno'])){
                                echo $directorio['telefonoAlterno'];
                             }elseif($directorio['telefonoCasa']){
                                echo $directorio['telefonoCasa'];
                             }else{
                                echo "no hay telefonos";
                             }
                             
                            ?></td>
                            <td><?php echo $directorio['telefonoExtencion']; ?></td>
                            <td><?php if ($directorio['region'] == 'CDMX') {
                              echo 'Centro';
                            }else{
                             echo $directorio['region']; 
                            }?>
                             </td>
                              <td class = "text-center">
                              <a style="cursor: pointer;" onclick="ver('<?php echo $directorio['id'];?>');">
                              <i class="fa fa-search"></i> 
                              </a>
                              </a>
                            </td>
                            <td class = "text-center">
                              <a style="cursor: pointer;" onclick="modificar('<?php echo $directorio['id'];?>');">
                              <i class="fa fa-edit"></i>
                              </a> 
                            </td>
                            <!--<td>
                              <a style="cursor: pointer;" onclick="eliminar('<?php //echo $directorio['id'];?>','<?php //echo $directorio['region'];?>');">
                              <i class="fa fa-trash text-red"></i> 
                              </a>
                            </td>-->
                          </tr>
                          <?php
                          }
                         ?>
                         </tbody>
                        </table>
                      </div>
                      <div class="tab-pane <?php echo $claseProveedor;?>" id="tab_2">                          
                        <table id="tblclasecliente" class="table table-bordered table-striped small">
                          <thead>
                            <th>Razón social</th>
                            <th>RFC</th>
                            <th>Nombre comercial</th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </thead>
                                                
                          <tbody>
                          <?php 
                          foreach($proveedores as $proveedor){
                          ?>                         
                          <tr>
                            <td><?php echo $proveedor["razonSocial"]?></td>
                            <td><?php echo $proveedor['rfc'];?></td>
                            <td><?php echo $proveedor['nombreComercial'];?></td>
                            <td class = "text-center">
                              <a style="cursor: pointer;" onclick="verProveedor('<?php echo $proveedor['idproveedor'];?>');">
                              <i class="fa fa-search"></i> 
                              </a>
                            </td>
                          </tr>
                          <?php
                          }
                         ?>
                         </tbody>
                        </table>
                      </div>
                      <div class="tab-pane <?php echo $claseCliente;?>" id="tab_3">                          
                        <table id="tblclaseCliente" class="table table-bordered table-striped small">
                          <thead>
                            <th>Razón social</th>
                            <th>RFC</th>
                            <th>Nombre comercial</th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </thead>
                                                
                          <tbody>
                          <?php 
                          foreach($clientes as $cliente){
                          ?>                         
                          <tr>
                            <td><?php echo strtolower($cliente["razonSocial"])?></td>
                            <td><?php echo $cliente['rfc'];?></td>
                            <td><?php echo $cliente['nombreComercial'];?></td>
                              <td class = "text-center">
                              <a style="cursor: pointer;" onclick="verCliente('<?php echo $cliente['idclientes'];?>');">
                              <i class="fa fa-search"></i> 
                              </a>
                            </td>
                          </tr>
                          <?php
                          }
                         ?>
                         </tbody>
                        </table>
                      </div>
                      <div class="tab-pane <?php echo $claseProveedor;?>" id="tab_4">                          
                        <table id="tblclaseMexico" class="table table-bordered table-striped small">
                          <thead>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono </th>
                            <th>Región</th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </thead>
                                                
                          <tbody>
                          <?php 
                          foreach($Representantes as $Representante){
                          ?>                         
                          <tr>
                            <td><?php echo  ucwords(strtolower($Representante["reprecentante_nombres"]." ".$Representante['reprecentante_apellido_paterno']." ".$Representante['reprecentante_apellido_materno']))?></td>
                            <td><?php if(!$Representante['reprecentante_correo']){ echo 'sin correo'; } else{ echo $Representante['reprecentante_correo']; }?></td>
                            <td><?php 
                            if (!empty($Representante['telefono'])) { 
                                echo intval(preg_replace('/[^0-9]+/', '', $Representante['telefono']), 10);   
                             }elseif(!empty($Representante['telefonoSecundario'])){
                                echo intval(preg_replace('/[^0-9]+/', '', $Representante['telefonoSecundario']), 10);
                             }elseif(!empty($Representante['telefonoAlterno'])){
                                echo intval(preg_replace('/[^0-9]+/', '', $Representante['telefonoAlterno']), 10);
                             }elseif($Representante['telefonoCasa']){
                                echo intval(preg_replace('/[^0-9]+/', '', $Representante['telefonoCasa']), 10);
                             }else{
                                echo "no hay telefonos";
                             }
                             
                            ?></td>
                            <td><?php if ($Representante['region'] == 'CDMX') {
                              echo 'Centro';
                            }else{
                             echo $Representante['region']; 
                            }?>
                             </td>
                              <td class = "text-center">
                              <a style="cursor: pointer;" onclick="ver('<?php echo $Representante['id'];?>');">
                              <i class="fa fa-search"></i> 
                              </a>
                              </a>
                            </td>
                            <td class = "text-center">
                              <a style="cursor: pointer;" onclick="modificar('<?php echo $Representante['id'];?>');">
                              <i class="fa fa-edit"></i> 
                            </td>
                            <td></a>
                              <a style="cursor: pointer;" onclick="eliminar('<?php echo $Representante['id'];?>','<?php echo $Representante['region'];?>');">
                              <i class="fa fa-trash text-red"></i> 
                              </a>
                            </td>
                          </tr>
                          <?php
                          }
                         ?>
                         </tbody>
                        </table>
                      </div>
                    <!-- /.tab-content -->
                  </div>
                  <!--/.Tabs-->
                  
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
            ¿Quiere quitar a este empleado del directorio telefónico?<b id="categoriaEliminar"></b>
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