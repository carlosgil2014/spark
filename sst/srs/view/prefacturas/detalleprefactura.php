<div class="modal-header">
        <div class="row">
            <div class="col-lg-2">
                <h6 class="modal-title">
                    <?php 
                        if(isset($opcion))
                            echo ($opcion == "Prefacturar") ? "Prefactura" : "Conciliar";
                        else
                            echo "Prefactura";
                    ?>
                </h6>
            </div>
        </div> 
        <div class="row">
           <div class="form-group col-lg-8" >
                <label>Cliente a prefacturar</label>
                <div class="form-groupcol-lg-12" >
                    <select class="form-control input-sm" name="Datos[idClientePrefactura]" required>
                        <option hidden selected value="0">--- Seleccione Cliente---</option>
                        <?php 
                        foreach ($datosClientes as $cliente)
                        {
                            if(isset($idCliente)){
                                if($idCliente != $cliente['idclientes']) {
                            ?>
                                <option value="<?php echo $cliente['idclientes'] ?>"><?php echo ($cliente["cliente"]);?></option>
                            <?php
                                }
                                else
                                {
                            ?>
                                <option value="<?php echo $cliente['idclientes'] ?>" selected><?php echo ($cliente["cliente"]);?></option>
                            <?php
                                }
                            }
                            else{
                            ?>
                                <option value="<?php echo $cliente['idclientes'] ?>"><?php echo ($cliente["cliente"]);?></option>
                            <?php
                            }
                        }
                      ?>
                    </select>
                </div>
            </div>
        </div> 
</div>
<div class="modal-body">
    <form>
        <table id="Idtabla"  style="width:100%; "  cellpadding="10">
            <tbody>
                <?php 
                $totalPu = 0;
                $totalC = 0;
                $totalT = 0;
                for($i = 0; $i < count($datos); $i++)
                {
                    $tmpPu = floatval($datos[$i]['precio']) * floatval($datos[$i]['maximo']);
                    $tmpC =  floatval($datos[$i]['maximo']) *  floatval($datos[$i]['precio']) * floatval((1*($datos[$i]['comisionagencia']/100)));
                    $tmpT = $tmpPu + $tmpC;
                    $totalPu += $tmpPu;
                    $totalC += $tmpC;
                        if($detalle == "cd")
                            $clase = "";
                        else
                            $clase = "hidden";
                ?>  
                    <tr>
                        <td>
                        <?php 
                        if(isset($datos[$i]['ncotizacion']) && $datos[$i]['ncotizacion'] != "")
                            echo "COT-".$datos[$i]['clave']."-".$datos[$i]['anio']."-".$datos[$i]['ncotizacion'];
                        if(isset($datos[$i]['norden']) && $datos[$i]['norden'] != "")
                            echo "OS-".$datos[$i]['clave']."-".$datos[$i]['anio']."-".$datos[$i]['norden'];

                        ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style='border-bottom: 0px;' class="<?php echo $clase;?>">
                        <td align='center' class='col-xs-6 col-lg-3 TipoPlan'> <b>TIPO DE PLAN</b></td>
                        <td class='col-xs-6 col-lg-5 TipoServicio'> <b>TIPO DE SERVICIO</b></td>
                        <td class='col-xs-6 col-lg-1'> <b></b></td>
                        <td class='col-xs-6 col-lg-1'> <b></b></td>
                        <td class='col-xs-6 col-lg-1'> <b></b></td>
                    </tr>
                    <tr align='center' class="<?php echo $clase;?>">
                        <td class='col-xs-6 col-lg-3'><?php echo $datos[$i]["tipoplan"];?></td>
                        <td class='col-xs-6 col-lg-5'align='left'><?php echo $datos[$i]["tiposervicio"];?></td>
                    </tr>
                    <tr class="<?php echo $clase;?>">
                        <td align='center' class='col-xs-6 col-lg-1 Cantidad'><b>Cantidad</b></td>
                        <td align='left' class='col-xs-6 col-lg-5 Concepto'> <b>Concepto</b></td>
                        <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Unitario</b> </td>
                        <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Total</b> </td>
                        <td align='center'  class='col-xs-6 col-lg-2 PUnitario'><b>Comisión</b></td>
                        <td align='center' class='col-xs-6 col-lg-2 SubTotal'><b>Subtotal</b></td>
                    </tr>   
                    <tr align='center' class='filaRubro editables <?php echo $clase;?>' tipo = "<?php echo $datos[$i]["tipo"];?>" dis = "<?php echo $datos[$i]["maximo"];?>" com="<?php echo $datos[$i]["comisionagencia"];?>" tp = "<?php echo $datos[$i]["tipoplan"];?>" ts = "<?php echo $datos[$i]["tiposervicio"];?>" idcon = "<?php echo $datos[$i]["idconcepto"];?>">
                        <td align='center' class='col-xs-6 col-lg-1' ><input type="number" class = "form-control input-sm cantidad text-center" value = "<?php echo $datos[$i]["maximo"];?>" max="<?php echo $datos[$i]["maximo"];?>" min="1" required></td>
                        <td align='left'   class='col-xs-6 col-lg-5'><?php echo $datos[$i]["concepto"];?></td>
                        <td align='center' class='col-xs-6 col-lg-2'><?php echo "$".number_format($datos[$i]['precio'],2);?></td>
                        <td align='center' class='col-xs-6 col-lg-2'>$<?php echo number_format($tmpPu,2);?></td>
                        <td align='center'><a  class='tool' data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='<?php echo $datos[$i]['comisionagencia'];?> %'>$ <?php echo number_format($tmpC,2); ?> </a></td>
                        <td>$ <?php echo number_format($tmpT,2);?></td>
                    </tr>
                    <tr class="filaRubro editablesPf">
                        <td></td>
                        <td class="text-justify col-lg-3"><?php echo $datos[$i]["descripcion"];?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="<?php echo $clase;?>">
                        <td><br></td>
                    </tr>
                <?php
                }
                $totalT += ($totalPu + $totalC);
                ?>
                    <?php if($opcion == "Prefacturar" || $opcion == ""){?>
                    <tr>
                        <td class="col-lg-1"></td>
                        <td class="col-lg-5"></td>
                        <td class="col-lg-1"></td>
                        <td class='TipoPfmodal col-lg-2' align="center">Descuento</td>
                        <td class='col-lg-3' colspan="2" align="center"><input class="form-control input-sm text-center" type="number" min = "0" id="descuento" /></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td><br></td>
                    </tr>
                    <tr class="motivo" hidden>
                        <td class="col-lg-1"></td>
                        <td class="col-lg-5"></td>
                        <td class='col-lg-2' align="center">Motivo: </td>
                        <td class='col-lg-4' colspan="3" align="center"><textarea class="form-control input-sm" type="text" style="resize:none;" id="motivo" name="Datos[motivo]"></textarea></td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                    <tr>
                        <td class="col-lg-1"></td>
                        <td class="col-lg-5"></td>
                        <td class='TipoOSmodal col-lg-1' align="center">Totales: </td>
                        <td class='TipoOSmodal col-lg-1'  align="center" id="sumaPT" ><?php echo '$ '.number_format($totalPu,2);?></td>
                        <td class='TipoOSmodal col-lg-2'  align="center" id="sumaC" ><?php echo '$ '.number_format($totalC,2);?></td>
                        <td class='TipoOSmodal col-lg-2'  align="center" id="sumaT" ><?php echo '$ '.number_format($totalT,2);?></td>
                    </tr>
            </tbody>
        </table>
        <input id="importe" value="<?php echo number_format($totalT,2)?>" hidden>
        <div class="row">
            <div class="form-group col-lg-12">
                <label><?php if($detalle=="cd")echo "Detalle (opcional)"; elseif ($detalle == "sd") echo "Escriba como quiere que aparezca el concepto en su prefactura."?></label>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-12">
                <textarea class="form-control" style="resize:none;" name="Datos[detalle]"></textarea>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary btn-sm" opcion="<?php echo $opcion;?>" id="btnGuardar">Guardar</button>
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
</div>