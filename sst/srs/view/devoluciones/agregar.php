<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h5 class="modal-title">PF-<?php echo $datosPrefactura["clave"];?>-<?php echo $datosPrefactura["anio"];?>-<?php echo $datosPrefactura["nprefactura"];?></h5>
</div>
<div class="modal-body">
    <div class="row">
        <div class="form-group" id="div_alert" style="display:none;">
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-danger" >
                    <strong>¡Aviso!</strong> <!-- <a onclick="cerrar('div_alert')" href="#" class="pull-right"><i class="fa fa-close"></i></a> -->
                    <br><p id="p_alert"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <form id="formGuardar">
            <table class="table table-bordered table-condensed small ">
                 <tr class="text-center">
                    <td>Motivo</td>
                    <td colspan="2"><input id="servicio" class="form-control input-sm" type="text"></td>
                    <td><input class="form-control input-sm text-center" type="date" value="<?php echo date('Y-m-d');?>" readonly="true"></td>
                </tr>
                <tr class="text-center">
                    <td>Tipo de Plan</td>
                    <td><?php echo $datos[0]["tipoplan"];?></td>
                    <td>Tipo de Servicio</td>
                    <td><?php echo $datos[0]["tiposervicio"];?></td>
                </tr>
                <tr class="text-center bg-primary">
                    <td>Cantidad</td>
                    <td>Concepto</td>
                    <td>Disponible</td>
                    <td>Importe</td>
                   
                </tr> 
                <tr class="text-center">
                    <td>1</td>
                    <td>Devolución</td>
                    <td class="bg-warning">$ <?php echo number_format($datos[0]['maximo'],2)?></td>
                    <td><input id="maximo" class="form-control input-sm text-center" type="number" step="0.01" min="0.01" max="<?php echo $datos[0]['maximo']?>" name="devolucion" value="<?php echo $datos[0]['maximo']?>" onchange="validar(this);"></td>
                </tr> 
            </table>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default input-sm" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success input-sm" onclick="guardar('<?php echo base64_encode($datosPrefactura["idprefactura"]);?>','<?php echo base64_encode($datos[0]["id_rubro"]);?>');">Guardar</button>
</div>