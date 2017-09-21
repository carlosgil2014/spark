  <?php
    if(!isset($_SESSION['spar_usuario']))
        header('Location: ../../view/index.php?accion=index');
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
        <a href="../../../index.php?accion=index" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A | S</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Administrativo | Spar</span>
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
          Alta de Celulares
            <small>Módulo de Sistemas</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Inicio > Inventario > Celulares > Alta de Celulares</a></li>
          </ol>
        </section>     

        <section class="content">
          <div class="row">
            <div class="col-md-12">
        
              <div class="box box-primary">
                <div class="box-header with-border">
                          <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#agregarCelular">Agregar Celular</button>
                </div>

                <div>
                  <div class="modal fade" id="agregarCelular" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><b>Agregar un celular</b></h4>
                      </div>
                      <div class="modal-body">
                        <form id="formularioAgregar" role="form">
                          <table border="0" width="100%">

                            <div class="form-group col-md-6">
                              <label class="control-label">Marca</label>
                              <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true" onchange="cargarModelos(this,'0');"  name="marca" required="required">
                              <?php 
                              foreach ($marcas as $marca){                              
                              ?>
                              <?php
                              }
                              ?>
                              </select>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                              <div class="form-group  col-md-6">
                              <label class="control-label">Modelo</label>
                              <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" name="modelo" id="modelos0">
                              </select>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                              <div class="form-group col-md-6 ">
                                <label for="imei">IMEI :</label>
                                <input type="text" class="form-control" id="imei" required="required" name="imei" pattern="[0-9]{15}" data-error="Es un campo obligatorio 15 numeros" placeholder="123456789012345">
                              </div>
                                <div class="form-group col-md-6 ">
                                <label for="sim">SIM :</label>
                                <input type="text" class="form-control" id="sim" required="required" name="sim" name="imei" pattern="[A-Za-z0-9]{21}" placeholder="12345678901234567890F">
                              </div>
                              <input type="hidden" name="guardar" id="guardar" value="guardar">
                          </table>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="submit" name="enviar" id="agregar" class="btn btn-primary">Agregar</button>
                            </div>
                            <tr>
                              <td colspan="2">
                                  <div id="mensaje"></div>
                            </td>
                        </tr>
                    </form>
                  </div>
                    </div>
              </div>
            </div>
          </div>

        </div>
      </div>

          </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Celulares</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="tblCel" class="table table-bordered table-striped">
                <thead>
                  <th>No.</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>IMEI</th>                  
                  <th>SIM</th>              
                  <th></th>
                </thead>
                <tbody>
                     <?php 
                    foreach($celular as $cel){
                      $btnEdit='<a class="btn btn-primary" data-toggle="modal" data-target="#update" onclick="editarProducto('.$cel['idCelular'].')">Editar</a>';
                      $btnEliminar='<a class="btn btn-danger" href="javascript:eliminarProducto('.$cel['idCelular'].');">Eliminar</a>';
                    ?>
                    <tr>
                    <?php
                        echo 
                        '<td>'.$cel["idCelular"].'</td>
                        <td>'.$cel['marca'].'</td>
                        <td>'.$cel['modelo'].'</td>
                        <td>'.$cel['imei'].'</td>
                        <td>'.$cel['sim'].'</td>
                        <td>
                        '.$btnEdit.'
                        '.$btnEliminar.'
                        </td>
                        </tr>';
                      ?>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
              </table>
            </div>

            <div id="modalEliminar" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Celular/Eliminar</h4>
          </div>
          <div class="modal-body text-center">
          ¿Eliminar el celular <b id="celularEliminar"></b>?
          </div>
          <div class="modal-footer">
            <button type="button" id="eliminar" class="btn btn-sm btn-danger" data-dismiss="modal">Continuar</button>
          </div>
        </div>
      </div>
    </div>

                  <div class="modal fade" id="Editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    
                  </div>

        </section>

        <!-- ./col -->

      </div>
      <!-- Termina el contenido general de la página -->
      
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
    <!-- DataTables -->
    <script src="../../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- Index Módulo Administrativo -->
    <script src="../../js/V1/index.js"></script>
     <script src="../../js/celular/celular.js"></script>
  </body>
</html>