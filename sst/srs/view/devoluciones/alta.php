<?php
if(!isset($_SESSION['spar_usuario']))
    header('Location: index.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
    <title>Módulo de Control de Recursos | Spar México</title>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../assets/css/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../assets/css/AdminLTE.min.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap/bootstrap-select.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../../assets/css/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
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
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <?php 
            include_once("../../../view/includes/menuIzquierdo.php");
          ?>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!-- <li class="header">Solicitudes</li> -->
            <li>
              <a style="cursor: pointer;" onclick="agregar();"> 
                <i class="fa fa-plus"></i> <span>Agregar</span>
              </a>
            </li>
            <li>
              <a href="../../index.php?accion=index">
                <i class="fa fa-arrow-left"></i> <span>Regresar</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- right column -->
            <div class="col-md-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Devoluciones/Nueva</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <form id="formDevolucion" method="POST" action="index.php?accion=listaClientes" >
                      <div class="form-group col-lg-7" >
                        <label>Cliente</label>
                        <select class="form-control input-sm" id="clientes" data-container="body" name="Datos[idCliente]" data-live-search="true" required>
                          <option data-hidden="true" selected value="0">--- Seleccione Cliente---</option>
                          <?php 
                            foreach ($datosClientes as $cliente) {
                            ?>
                            <option value="<?php echo $cliente['idclientes']?>" <?php if(isset($idCliente)) if($cliente['idclientes'] == $idCliente) echo "selected";?>><?php echo $cliente["nombreComercial"]." - ".$cliente["razonSocial"];?></option>
                            <?php 
                            }
                          ?> 
                        </select>
                      </div>
                      <div class="form-group col-lg-2" >
                        <label>De</label>
                        <input  type="date" class="form-control input-sm" value="<?php if(isset($fechaInicial))echo $fechaInicial; else echo $fecha;?>" name="Datos[fechaInicial]" required>
                      </div>
                      <div class="form-group col-lg-2" >
                        <label>Hasta</label>
                        <input type="date" class="form-control input-sm" value="<?php if(isset($fechaFinal))echo $fechaFinal; else echo $fecha;?>" name="Datos[fechaFinal]" required>
                      </div>
                      <div class="form-group col-lg-1" >
                        <label>&nbsp;</label>
                        <div>
                          <button type="submit" class="btn btn-info pull-right btn-sm btn-flat">Buscar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <?php
                  if(isset($datosPrefacturas))
                  {
                  ?>
                  <div class="table-responsive container-fluid row">
                    <table id="tblPrefacturas" class="table table-bordered table-striped small">
                      <thead>
                        <tr>
                          <th>Folio</th>
                          <th>Fecha</th>
                          <th>Servicio</th>
                          <th>Total</th>
                          <th>Disponible</th>
                          <th>OS's</th>
                          <th>DV's</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        foreach($datosPrefacturas as $prefactura){
                        ?>
                        <tr>
                          <td><?php echo "PF-".$prefactura["clave"]."-".$prefactura["anio"]."-".$prefactura["nprefactura"];?></td>
                          <td><?php echo date_format(date_create($prefactura["fechaInicial"]),"d-m-Y");?></td>
                          <td><?php echo $prefactura["servicio"];?></td>
                          <td class="text-center">$ <?php echo number_format($prefactura["cantidad"]*$prefactura["precioUnitario"]*(1+($prefactura["comision"]/100)),2);?></td>
                          <td class="text-center">$ <?php echo number_format($prefactura["saldoAnticipado"],2);?></td>
                          <td class = "text-center">
                            <a style="cursor:pointer;" onclick="detalleConcepto('<?php echo $prefactura['idprefactura'];?>','<?php echo $prefactura['idprefacturaconcepto'];?>');">
                              <i class="fa fa-search"></i>
                            </a>
                          </td>
                          <td class = "text-center">
                            <a style="cursor:pointer;" onclick="agregar('<?php echo $prefactura['idprefactura'];?>','<?php echo $prefactura['idprefacturaconcepto'];?>',<?php echo $prefactura["saldoAnticipado"];?>);">
                              <i class="fa fa-mail-reply-all"></i>
                            </a>
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <?php 
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php
      include_once("../../../view/includes/footer.php");
      ?>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <!-- <div class="control-sidebar-bg"></div> -->
      <div class="modal fade" id="modalDevolucion" role="dialog">    
      </div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <script src="../../../assets/js/jquery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../../../assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Validaciones -->
    <script src="../../../assets/js/validacion/validacion.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/js/app.min.js"></script>
    <!-- Funciones Generales -->
    <script src="../../../assets/js/funciones.js"></script>
    <!-- Bootstrap select js -->
    <script src="../../../assets/js/bootstrap/bootstrap-select.min.js"></script>
    <!-- Index Bancos -->
    <script src="../../js/V1/devoluciones/index.js"></script>
  </body>
</html>
