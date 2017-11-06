<?php 
    $datosConcepto = $datos;
    $datosOrden = $datosOs;
    $prefactura = $datosPrefactura;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h5 class="modal-title">PF-<?php echo $prefactura["clave"];?>-<?php echo $prefactura["anio"];?>-<?php echo $prefactura["nprefactura"];?></h5>
</div>
<div class="modal-body" style="height: 400px; overflow-y: auto;">
    <div class="table-responsive">
        <table class="table table-bordered table-condensed small ">
            <tr class="text-center">
                <td>Tipo de Plan</td>
                <td colspan="2"><?php echo $datosConcepto[0]["tipoplan"];?></td>
                <td>Tipo de Servicio</td>
                <td colspan="2"><?php echo $datosConcepto[0]["tiposervicio"];?></td>
            </tr>
            <tr class="text-center bg-primary">
                <td>Cantidad</td>
                <td>Concepto</td>
                <td>Precio Unitario</td>
                <td>Total</td>
                <td>Comisión</td>
                <td>Subtotal</td>
            </tr> 
            <tr class="text-center">
                <td><?php echo $datosConcepto[0]["cantidad"];?></td>
                <td><?php echo $datosConcepto[0]["concepto"];?></td>
                <td>$ <?php echo number_format($datosConcepto[0]['precioUnitario'],2);?></td>
                <td>$ <?php echo number_format(($datosConcepto[0]['precioUnitario']*$datosConcepto[0]['cantidad']),2);?></td>
                <td><a  class='tool' data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='<?php echo $datosConcepto[0]['comision'];?> %'>$ <?php echo number_format($datosConcepto[0]['cantidad']*$datosConcepto[0]['precioUnitario'] *(1*($datosConcepto[0]['comision']/100)),2); ?> </a></td>
                <td>$ <?php echo number_format($datosConcepto[0]['total'],2);?></td>
            </tr> 
            <?php
            $cantidadTotal = 0;
            foreach ($datosOrden as $datosExistentes) 
            {
                if(!is_null($datosExistentes["cantidadOS"]))
                {
                    $cantidadTotal += $datosExistentes["totalOrden"];

                ?>
            <tr class="bg-success">
                <td colspan="6">
                    <?php 
                    $tipo = "DV";
                    if(strpos($datosExistentes["estado"],"Devolucion") === false){
                        $tipo = "OS";
                    }
                    echo $tipo."-".$datosExistentes["claveOrden"]; ?>-<?php echo $datosExistentes['anioOs']?>-<?php echo $datosExistentes['norden'] ?>
                </td>
            </tr>
            <tr class="text-center">
                <td><?php echo $datosExistentes["cantidadOS"];?></td>
                <td><?php echo $datosExistentes["conceptoOS"];?></td>
                <td>$ <?php echo number_format($datosExistentes['precioUnitarioOS'],2);?></td>
                <td>$ <?php echo number_format(($datosExistentes['precioUnitarioOS'] * $datosExistentes["cantidadOS"]),2);?></td>
                <td><a  class='tool' data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='<?php echo $datosExistentes['comisionOS'];?> %'>$ <?php echo number_format($datosExistentes['cantidadOS']*$datosExistentes['precioUnitarioOS'] *(1*($datosExistentes['comisionOS']/100)),2); ?> </a></td>
                <td>$ <?php echo number_format($datosExistentes['totalOrden'],2);?></td>
            </tr>
                <?php
                }
            }
            ?>
            <tr class="text-center">
                <td class="active" colspan="5">Total en OS's</td>
                <td class="active"><?php echo " $". number_format($cantidadTotal,2);?></td>
            </tr>
            <tr class="bg-danger text-center">
                <td colspan="5">
                    Descuento
                </td>
                <td >
                    <?php echo " $". number_format($prefactura["descuento"],2);?>
                </td>
            </tr>
             <tr class="text-center">
                <td class="bg-warning" colspan="5">Disponible</td>
                <td class="bg-warning"><?php echo " $". number_format((($datosConcepto[0]["total"]) - ($cantidadTotal)),2);?></td>
            </tr>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>