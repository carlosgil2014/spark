<?php
    if(!isset($_SESSION['spar_usuario']))
         header('Location: ../index.php');
    //Poner sesiones principales 



if(isset($_GET["activo"])){
  switch ($_GET["activo"]) {
    case '1':
      $claseCategorias = "active";
      $claseSubcategorias = "";
      $claseProductos = "";
      $claseMarcas = "";
      $claseModelos = "";

      break;
    case '2':
      $claseCategorias = "";
      $claseSubcategorias = "active";
      $claseProductos = "";
      $claseMarcas = "";
      $claseModelos = "";
      break;
    case '3':
      $claseCategorias = "";
      $claseSubcategorias = "";
      $claseProductos = "active";
      $claseMarcas = "";
      $claseModelos = "";
      break;
      case '4':
      $claseCategorias = "";
      $claseSubcategorias = "";
      $claseProductos = "";
      $claseMarcas = "active";
      $claseModelos = "";
      break;
      case '5':
      $claseCategorias = "";
      $claseSubcategorias = "";
      $claseProductos = "";
      $claseMarcas = "";
      $claseModelos = "active";
      break;
    
    default:
      $claseCategorias = "active";
      $claseSubcategorias = "";
      $claseProductos = "";
      $claseMarcas = "";
      $claseModelos = "active";
      break;
  }
}
else{
  $claseCategorias = "active";
  $claseSubcategorias = "";
  $claseProductos = "";
  $claseMarcas = "";
  $claseModelos = "";

}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="Plantilla general para el desarrollo de los módulos del Sistema Spar Todopromo SST">
  <meta name="author" content="Maria de los Angeles Malagon, Salvador Luna, Victor Nava y Gerardo Medina">
  <title>Modulo de Control de Recursos | Spar México</title>
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
        <ul class="sidebar-menu">


      <!-- Barra de separación entre menus -->
        <li class="header">Categorias</li>
      <!-- Fin de la barra de separación entre menus -->
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
          
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Index</a></li>
          </ol>
          <div class="row">
            <!-- right column -->
            <div class="col-md-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Categorias/Principal</h3>
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
                    <li class="<?php echo $claseCategorias;?>"><a href="#tab_1" data-toggle="tab" aria-expanded="false" >Categorias</a></li>
               
                      <li class="<?php echo $claseSubcategorias;?>"><a href="#tab_2" data-toggle="tab" aria-expanded="true">Subcategorias</a></li>
                      
                      <li class="<?php echo $claseProductos;?>"><a href="#tab_3" data-toggle="tab" aria-expanded="false">Productos</a></li>

                      <li class="<?php echo $claseMarcas;?>"><a href="#tab_4" data-toggle="tab" aria-expanded="false">Marcas</a></li>
                      <li class="<?php echo $claseModelos;?>"><a href="#tab_5" data-toggle="tab" aria-expanded="false">Modelos</a></li>
                    
                    </ul>
                    
                    <div class="tab-content">
                      <div class="tab-pane <?php echo $claseCategorias;?>" id="tab_1">
                          
                        <table id="tblCategorias" class="table table-bordered table-striped">
                          <thead>
                            <th>Categoria   <a  class="btn btn-success" data-toggle="modal" data-dismiss="modal" onclick="agregarCategoria()">Agregar</a></th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>
                          <?php 
                          foreach($categorias as $Categoria){
                          $btnEdit='<a class="btn btn-primary" data-toggle="modal" data-target="#update" onclick="modificarCategoria('.$Categoria['idCategoria'].')">Editar</a>';
                          $btnEliminar='<a class="btn btn-danger" href="javascript:eliminarCategoria('.$Categoria['idCategoria'].');">Eliminar</a>';                       
                          ?>                          
                          <tr>
                            <td><?php echo $Categoria["categoria"]?></td>
                         <?php
                         echo
                          '<td>
                          '.$btnEdit.'
                          '.$btnEliminar.'
                         </td>'
                         ?>
                          </tr>
                          <?php
                          }
                         ?>
                         </tbody>
                        </table>
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane <?php echo $claseSubcategorias;?>" id="tab_2">
                        <table id="tblSubcategorias" class="table table-bordered table-striped">
                          <thead>
                            <th>Subcategoria  <a class="btn btn-success" data-toggle="modal" data-dismiss="modal" onclick="agregarSubCategoria()">Agregar</a></th>
                            <th>Categoria</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>
                          <?php 
                          foreach($subcategorias as $subcategoria){
                          $btnEdit='<a class="btn btn-primary" data-toggle="modal" data-target="#update" onclick="modificarSubCategoria('.$subcategoria['id'].')">Editar</a>';
                          $btnEliminar='<a class="btn btn-danger" href="javascript:eliminarSubCategoria('.$subcategoria['id'].');">Eliminar</a>';                      
                          ?>
                      <tr>                   
                              
                          <td><?php echo $subcategoria["subcategoria"]?></td>
                          <td><?php echo $subcategoria["categoria"]?></td>
                           <?php
                            echo
                          '<td>
                          '.$btnEdit.'
                          '.$btnEliminar.'
                         </td>'
                         ?>                     
                    </tr>
                          <?php
                          }
                         ?>
                         </tbody>
                        </table>

                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane <?php echo $claseProductos;?>" id="tab_3">
                        <table id="tblProductos" class="table table-bordered table-striped">
                          <thead>
                            <th>Producto   <a class="btn btn-success" data-toggle="modal" data-dismiss="modal" onclick="agregarProducto()">Agregar</a></th>
                            <th>Categoria</th>
                            <th>Subcategoria</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>
                          <?php 
                          foreach($productos as $producto){
                          $btnEdit='<a class="btn btn-primary" data-toggle="modal" data-target="#update" onclick="modificarProducto('.$producto['idProducto'].')">Editar</a>';
                          $btnEliminar='<a class="btn btn-danger" href="javascript:eliminarProducto('.$producto['idProducto'].');">Eliminar</a>';                       
                          ?>
                      <tr>                   
                              
                          <td><?php echo $producto["producto"]?></td>
                          <td><?php echo $producto["categoria"]?></td>
                          <td><?php echo $producto["subcategoria"]?></td>
                          <?php
                            echo
                          '<td>
                          '.$btnEdit.'
                          '.$btnEliminar.'
                         </td>'
                         ?>  
                    </tr>
                          <?php
                          }
                         ?>
                         </tbody>
                        </table>

                      <!-- /.tab-pane -->
                    </div>
                    <div class="tab-pane <?php echo $claseMarcas;?>" id="tab_4">
                        <table id="tblMarcas" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>Marca  <a  class="btn btn-success" data-toggle="modal" data-dismiss="modal" onclick="agregarMarca()">Agregar</a></th>
                            <th>Opciones</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php 
                          foreach($marcas as $marca){
                          $btnEdit='<a class="btn btn-primary" data-toggle="modal" data-target="#update" onclick="modificarMarca('.$marca['idmarca'].')">Editar</a>';
                          $btnEliminar='<a class="btn btn-danger" href="javascript:eliminarMarca('.$marca['idmarca'].');">Eliminar</a>';                       
                          ?>
                      <tr>                   
                              
                          <td><?php echo $marca["marca"]?></td>
                          <?php
                            echo
                          '<td>
                          '.$btnEdit.'
                          '.$btnEliminar.'
                         </td>'
                         ?>  
                    </tr>
                          <?php
                          }
                         ?>
                         </tbody>
                        </table>
                      </div>
                      <div class="tab-pane <?php echo $claseModelos;?>" id="tab_5">
                        <table id="tblModelos" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                            <th>Modelos   <a  class="btn btn-success" data-toggle="modal" data-dismiss="modal" onclick="agregarModelo()">Agregar</a></th>
                            <th>Marca</th>
                            <th>Opciones</th>
                            </tr>
                            <tbody>
                              <?php 
                          foreach($modelos as $modelo){
                          $btnEdit='<a class="btn btn-primary" data-toggle="modal" data-target="#update" onclick="modificarModelo('.$modelo['idModelo'].')">Editar</a>';
                          $btnEliminar='<a class="btn btn-danger" href="javascript:eliminarModelo('.$modelo['idModelo'].');">Eliminar</a>';                       
                          ?>
                      <tr>                   
                              
                          <td><?php echo $modelo["modelo"]?></td>
                          <td><?php echo $modelo["marca"]?></td>
                          <?php
                            echo
                          '<td>
                          '.$btnEdit.'
                          '.$btnEliminar.'
                         </td>'
                         ?>  
                    </tr>
                          <?php
                          }
                         ?>
                            </tbody>
                          </thead>
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
      include_once("../../../view/includes/footer.php");
      ?>

            <div class="modal fade" id="agregarCategoria" role="dialog">
            </div>
            <div class="modal fade" id="agregarSubCategoria" role="dialog">
            </div>
            <div class="modal fade" id="agregarProducto" role="dialog">
            </div>

    <!-- Modal Eliminar -->
      <div id="modalEliminar" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Eliminar</h4>
            </div>
            <div class="modal-body text-center">
            ¿Quieres eliminar <b id="categoriaEliminar"></b>?
            </div>
            <div class="modal-footer">
              <button type="button" id="eliminar" class="btn btn-sm btn-danger" data-dismiss="modal">Continuar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Eliminar -->
    <!-- Fin del pie de página -->
    <!-- ./wrapper -->
    <!-- jQuery 2.2.3 -->
    <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../../assets/js/jquery/jquery-ui.js"></script>
    <!-- DataTables -->
    <script src="../../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Validaciones -->
    <script src="../../../assets/js/validacion/validacion.js"></script>   
    <!--Funciones Generales-->
    <script src="../../../assets/js/funciones.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- Index Módulo Administrativo -->
    <script src="../../js/V1/categorias/index.js"></script>
    <script src="../../js/V1/subcategorias/index.js"></script>
    <script src="../../js/V1/productos/index.js"></script>
    <script src="../../js/V1/marcas/index.js"></script>
    <script src="../../js/V1/modelos/index.js"></script>
  </body>
</html>