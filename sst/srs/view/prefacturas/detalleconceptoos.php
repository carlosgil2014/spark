<?php 
    $datosConcepto = $datos;
    $datosPf = $datosPrefactura;
    $orden = $datosOrden;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">OS-<?php echo $orden["clave"];?>-<?php echo $orden["anio"];?>-<?php echo $orden["norden"];?></h4>
</div>
<div class="modal-body">
    <table id="Idtabla"  style="width:100%; "  cellpadding="10">
        <tbody>
            <tr style='border-bottom: 0px;'>
                <td align='center' class='col-xs-6 col-lg-3 TipoPlan'> <b>TIPO DE PLAN</b></td>
                <td class='col-xs-6 col-lg-5 TipoServicio'> <b>TIPO DE SERVICIO</b></td>
                <td class='col-xs-6 col-lg-1'> <b></b></td>
                <td class='col-xs-6 col-lg-1'> <b></b></td>
                <td class='col-xs-6 col-lg-1'> <b></b></td>
            </tr>
            <tr align='center'>
                <td class='col-xs-6 col-lg-3'><?php echo $datosConcepto[0]["tipoplan"];?></td>
                <td class='col-xs-6 col-lg-5'align='left'><?php echo $datosConcepto[0]["tiposervicio"];?></td>
            </tr>
            <tr >
                <td align='center' class='col-xs-6 col-lg-1 Cantidad'><b>Cantidad</b></td>
                <td align='left' class='col-xs-6 col-lg-5 Concepto'> <b>Concepto</b></td>
                <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Unitario</b> </td>
                <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Total</b> </td>
                <td align='center'  class='col-xs-6 col-lg-2 PUnitario'><b>Comisión</b></td>
                <td align='center' class='col-xs-6 col-lg-2 SubTotal'><b>Sub_Total</b></td>
            </tr>   
            <tr align='center' class='filaRubro'>
                <td align='center' class='col-xs-6 col-lg-1'><?php echo $datosConcepto[0]["cantidad"];?></td>
                <td align='left'   class='col-xs-6 col-lg-5'><?php echo $datosConcepto[0]["concepto"];?></td>
                <td align='center' class='col-xs-6 col-lg-2'>$ <?php echo number_format($datosConcepto[0]['precioUnitario'],2);?></td>
                <td align='center' class='col-xs-6 col-lg-2'>$ <?php echo number_format(($datosConcepto[0]['precioUnitario']*$datosConcepto[0]['cantidad']),2);?></td>
                <td align='center'><a  class='tool' data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='<?php echo $datosConcepto[0]['comision'];?> %'>$ <?php echo number_format($datosConcepto[0]['cantidad']*$datosConcepto[0]['precioUnitario'] *(1*($datosConcepto[0]['comision']/100)),2); ?> </a></td>
                <td>$ <?php echo number_format($datosConcepto[0]['total'],2);?></td>
            </tr>
             <tr align='center' class='filaRubro'>
                <td></td>
                <td align='center' class='col-xs-6 col-lg-1'><?php echo $datosConcepto[0]["descripcion"];?></td>
            </tr>
            <?php
            $cantidadTotal = 0;
            foreach ($datosPf as $datosExistentes) 
            {
                if(!is_null($datosExistentes["cantidadPf"]))
                {
                    $cantidadTotal += $datosExistentes["cantidadPf"];

                ?>
                <tr class='TipoPfmodal'>
                    <td>
                       <?php echo ($datosExistentes["estado"] == "Conciliado") ? "CL": "PF";?>-<?php echo $datosExistentes["clavePf"]; ?>-<?php echo $datosExistentes['anioPf']?>-<?php echo $datosExistentes['nprefactura'] ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr align='center' class='filaRubro'>
                    <td align='center' class='col-xs-6 col-lg-1'><?php echo $datosExistentes["cantidadPf"];?></td>
                    <td align='left'   class='col-xs-6 col-lg-5'><?php echo $datosExistentes["conceptoPf"];?></td>
                    <td align='center' class='col-xs-6 col-lg-2'>$ <?php echo number_format($datosExistentes['precioUnitarioPf'],2);?></td>
                    <td align='center' class='col-xs-6 col-lg-2'>$ <?php echo number_format(($datosExistentes['precioUnitarioPf']*$datosExistentes['cantidadPf']),2);?></td>
                    <td align='center'><a  class='tool' data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='<?php echo $datosExistentes['comisionPf'];?> %'>$ <?php echo number_format($datosExistentes['cantidadPf']*$datosExistentes['precioUnitarioPf'] *(1*($datosExistentes['comisionPf']/100)),2); ?> </a></td>
                    <td>$ <?php echo number_format($datosExistentes['totalPf'],2);?></td>
                </tr>
                <?php
                }
            }
            ?>
            <tr>
                <td><br> <?php echo "TOTAL: ". $cantidadTotal;?></td>
            </tr>
            <tr>
                <td><br> <?php echo "Disponible: ". (($datosConcepto[0]["cantidad"]) - ($cantidadTotal));?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>