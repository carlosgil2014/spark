<?php
require_once('../conexion.php');
session_start();
  if(!isset($_SESSION['srs_usuario']))
    header('Location: ../view/index.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
    <title>IntraNet | Spar Todopromo</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

    <!--Jquery css-->
    <link rel="stylesheet" href="../css/jquery-ui.css">

    <!-- DataTables CSS -->
    <link href="../css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom Fonts -->
    <link href="../css/estilo.css" rel="stylesheet" type="text/css">

        <!-- Jquery multiselect -->
    <link rel="stylesheet" href="../css/jquery.multiselect.css">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../operaciones">Módulo de Estado de cuenta</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
                        </li> -->
                        <!-- <li><a href="../configuraciones/conceptos.php"><i class="fa fa-gear fa-fw"></i> Configuraciones</a>
                        </li> -->
                        <li class="divider"></li>
                        <li><a href="../controller/crudIndex.php?urlValue=logout"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu"> 
                        <li>
                            <a href="../view/index.php"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <br>
                <br>
                <div class="col-lg-12">
                  <h1 class="page-header">Estado de cuenta</h1>
                </div>
              </div>
            <!-- /.row -->
            <div class="row">
                <!--Muestra la clave, año y el numero de cotización-->
                <div id="lblCot" class="form-group col-xs-12 col-lg-12 text-right" >
                </div>

                <div class="row">
                  <div class="form-group input-sm col-lg-6" >
                    <label>Cliente</label>
                    <div class="row">
                      <div class="form-group col-xs-8 col-lg-11" >

                        <select class="form-control input-sm reporte cliente" name="cmbClientes[]" size="1" multiple="multiple" id="IdcmbClientes" onchange="filtrar();" required>
                          
                            <?php
                              /////////Conecta a la BD para mostrar los clientes almacenados en el combobox///////////////// 
                              $queryUsuario = "SELECT idusuarios FROM tblusuarios where user_name = '".$_SESSION['srs_usuario']."'";
                              $resultadoUsuario = mysql_query($queryUsuario,$conexion)or die(mysql_error());
                              $idUsuario = mysql_fetch_assoc($resultadoUsuario);

                              $query="SELECT idclientes,rfc,concat(razon_soc,' | ',rfc,' | ',nom_comercial) as cliente FROM tblclientes WHERE idclientes IN (SELECT idcliente FROM tblusuariosclientes WHERE idusuario = ".$idUsuario['idusuarios'].") order by razon_soc";                     
                              $resul=mysql_query($query,$conexion)or die(mysql_error());
                              while($cliente=mysql_fetch_assoc($resul))                
                              {           
                              ?>
                                <option value="<?php echo $cliente['idclientes'] ?>">&nbsp;&nbsp; <?php echo utf8_encode($cliente["cliente"]);?></option>
                              <?php  
                              }
                              ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group col-xs-12 col-lg-3" >
                    <label>De</label>
                    <input type="date" class="form-control reporte" id="fechaIn" value="<?php echo date('Y-m-d');?>" name="numIn" onchange="filtrar();" required>
                  </div>
                  <div class="form-group col-xs-12 col-lg-3" >
                    <label>Hasta</label>
                    <input type="date" class="form-control reporte" id="fechaFin" value="<?php echo date('Y-m-d');?>" name="numFin" onchange="filtrar();" required>
                  </div>
                  </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                        <div class="tablareportes">
                        
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                    <br><br><br><br><br>
                    <table class="table table-striped table-bordered table-hover hidden" id="tablaSaldos">
                      <thead>
                        <th style="color:#fff; background-color:#337ab7; text-align:center;">Saldo actual ($):</th>
                        <th style="color:#fff; background-color:#337ab7; text-align:center;">Saldo deudor ($):</th>
                      </thead>
                      <tbody>
                        <td><label id="idlblSaldoActual"></label></td>
                        <td><label id="idlblSaldoDeudor"></label></td>
                      </tbody>                      
                    </table>
                    </div>
                  </div>

              <!-- Modal -->
              <div id="IdModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <label id="idLabelTituloModal"></label> <h6 id="idSmallFecha"></h6><!-- <button type="button" class="close" data-dismiss="modal">&times;</button>    -->
                    </div>
                    <br>
                    <div class="modal-body"  id="IdModaldetalle">
                      
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>

                </div>
              </div>

            </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../js/jquery.min.js"></script>

      <!-- Ui jQuery-->
    <script src="../js/jquery-ui.min.js"></script>

    <!--Multi select  -->
    <script src="../js/jquery.multiselect.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../js/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>

    <script src="../js/estadocuenta/estadocuenta.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../js/sb-admin-2.js"></script>

     <script>
   

    function cambiarTitulo(titulo){
        document.getElementById('IdTituloOperaciones').innerHTML = titulo;   


    }
    </script>

</body>

</html>
